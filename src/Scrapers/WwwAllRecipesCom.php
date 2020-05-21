<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use RecipeScraper\ExtractsDataFromCrawler;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Most recipes are on the new design which provides JSON-LD.
 * Some are still served with the old design which does not.
 */
class WwwAllRecipesCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return (
            parent::supports($crawler)
            || (bool) $crawler->filter('[itemtype*="schema.org/Recipe"]')->count()
        ) && 'www.allrecipes.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler, array $json)
    {
        return parent::extractAuthor($crawler, $json) ?: $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="author"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler, array $json)
    {
        return parent::extractDescription($crawler, $json)
            ?: $this->extractString($crawler, 'div[itemprop="description"]');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractImage(Crawler $crawler, array $json)
    {
        return parent::extractImage($crawler, $json) ?: $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="image"]',
            ['content', 'src']
        );
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler, array $json)
    {
        return parent::extractIngredients($crawler, $json) ?: $this->extractArray(
            $crawler,
            '[itemprop="recipeIngredient"], [itemprop="ingredients"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        $instructions = Arr::get($json, 'recipeInstructions');

        if (! is_array($instructions)) {
            return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
        }

        $instructions = array_filter($instructions, function ($instruction) {
            return Arr::ofStrings($instruction) && array_key_exists('text', $instruction);
        });

        return array_column($instructions, 'text');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractName(Crawler $crawler, array $json)
    {
        return parent::extractName($crawler, $json)
            ?: $this->extractString($crawler, 'h1[itemprop="name"]' );
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        // @todo Find more recipes to test against!
        $notes = $this->extractArray($crawler, '.recipe-note p');

        if (! $notes) {
            return $this->extractArray(
                $crawler
                    ->filter('.recipe-footnotes li')
                    ->reduce(function (Crawler $node) : bool {
                        return ! $node->filter('.recipe-footnotes__header')->count();
                    })
            );
        }

        return $notes;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractYield(Crawler $crawler, array $json)
    {
        $yield = $crawler
            ->filter('.recipe-meta-item')
            ->reduce(function (Crawler $node, $i) {
                $header = $node->filter('.recipe-meta-item-header');

                return $header->count() === 0 || stripos($header->text(), 'servings') !== false;
            })
            ->filter('.recipe-meta-item-body');

        if (! $yield->count()) {
            return $this->extractString($crawler, '[itemprop="recipeYield"]', ['content', '_text']);
        }

        return $yield->first()->text();
    }
}
