<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;

class RecipesSparkPeopleCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        // Uses HTTPS scheme.
        return (bool) $crawler->filter('[itemtype="https://schema.org/Recipe"]')->count()
            && 'recipes.sparkpeople.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="author"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '#tags a');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        // Unfortunately we have to drop to the lower-level DOM API for access to text node values.
        $instructions = $crawler->filter('[itemprop="recipeInstructions"]');

        if (! $instructions->count()) {
            return null;
        }

        $return = [];

        foreach ($instructions->getNode(0)->childNodes as $childNode) {
            if (XML_ELEMENT_NODE === $childNode->nodeType) {
                $return[] = $childNode->nodeValue;
            }

            if (XML_TEXT_NODE === $childNode->nodeType) {
                $return[] = $childNode->wholeText;
            }
        }

        return $return;
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        // H1 with itemprop="name" is outside recipe scope.
        return $this->extractString($crawler, '[itemprop="name"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  string[]|null $instructions
     * @return string[]|null
     */
    protected function postNormalizeInstructions($instructions)
    {
        if (! Arr::ofStrings($instructions)) {
            return $instructions;
        }

        // For starters - remove leading digits.
        $instructions = array_map(function ($instruction) {
            return (string) s($instruction)->regexReplace('^\d+\.\s*', '');
        }, $instructions);

        // Then filter out servings and author info.
        $instructions = array_filter($instructions, function ($instruction) {
            $instruction = s($instruction);

            return ! (
                $instruction->startsWith('serving size:', false)
                || $instruction->startsWith('number of servings:', false)
                || $instruction->startsWith('recipe submitted by', false)
            );
        });

        return count($instructions) ? array_values($instructions) : null;
    }
}
