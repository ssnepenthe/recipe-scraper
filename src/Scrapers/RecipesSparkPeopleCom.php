<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @todo Consider extracting method for DOM access as in instructions/notes. Cookieandkate.com also.
 */
class RecipesSparkPeopleCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'recipes.sparkpeople.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '.submited_by [itemprop="author"]');
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

        if (! $instructions->count() || ! $first = $instructions->getNode(0)) {
            return null;
        }

        $return = [];
        $value = '';

        foreach ($first->childNodes as $childNode) {
            if (XML_TEXT_NODE === $childNode->nodeType) {
                $value .= $childNode->wholeText;
            } elseif (XML_ELEMENT_NODE === $childNode->nodeType) {
                if ('br' === $childNode->nodeName) {
                    $return[] = $value;
                    $value = '';
                } else {
                    $value .= $childNode->nodeValue;
                }
            }
        }

        if (! empty($value)) {
            $return[] = $value;
            $value = '';
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
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        // Unfortunately we have to drop to the lower-level DOM API for access to text node values.
        $notes = $crawler->filter('.tip_text');

        if (! $notes->count() || ! $first = $notes->getNode(0)) {
            return null;
        }

        $return = [];
        $value = '';

        foreach ($first->childNodes as $childNode) {
            if (XML_TEXT_NODE === $childNode->nodeType) {
                $value .= $childNode->wholeText;
            } elseif (XML_ELEMENT_NODE === $childNode->nodeType) {
                if ('br' === $childNode->nodeName) {
                    $return[] = $value;
                    $value = '';
                } else {
                    $value .= $childNode->nodeValue;
                }
            }
        }

        if (! empty($value)) {
            $return[] = $value;
            $value = '';
        }

        return $return;
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
        // Is null check for Psalm...
        if (is_null($instructions) || ! Arr::ofStrings($instructions)) {
            return $instructions;
        }

        // For starters - remove leading digits.
        $instructions = array_map(function ($instruction) : string {
            return (string) s($instruction)->regexReplace('^\d+\.\s*', '');
        }, $instructions);

        // Then filter out servings and author info.
        $instructions = array_filter($instructions, function ($instruction) : bool {
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
