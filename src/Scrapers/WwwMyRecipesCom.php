<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Has nutrition information.
 *
 * Has links to other recipes in ingredients.
 *
 * @todo Consider updating parent supports method to not be dependent on scheme.
 *       Consider extracting some sort of ->extractBodyBasedOnHeaderText() type method from times.
 */
class WwwMyRecipesCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        // Uses HTTPS scheme.
        return (bool) $crawler->filter('[itemtype="https://schema.org/Recipe"]')->count()
            && 'www.myrecipes.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="https://schema.org/Recipe"] [itemprop="author"] [itemprop="name"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractCookTime(Crawler $crawler)
    {
        $meta = $crawler->filter('.recipe-meta-item')->reduce(function (Crawler $node) : bool {
            $header = $node->filter('.recipe-meta-item-header');

            return $header->count() && false !== stripos($header->text(), 'cook time');
        });

        if (! $meta->count()) {
            return null;
        }

        return $this->extractString($meta, '.recipe-meta-item-body');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '.schema [itemprop="description"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="https://schema.org/Recipe"] [itemprop="image"]',
            ['content', 'data-src']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] p:last-child');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, '.schema [itemprop="name"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        $instructions = $crawler->filter('.recipe-instructions')->reduce(
            function (Crawler $node) : bool {
                $header = $node->filter('h3');

                return $header->count() && false !== stripos($header->text(), 'notes');
            }
        );

        if (! $instructions->count()) {
            return null;
        }

        return $this->extractArray($instructions, '.step');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPrepTime(Crawler $crawler)
    {
        $meta = $crawler->filter('.recipe-meta-item')->reduce(function (Crawler $node) : bool {
            $header = $node->filter('.recipe-meta-item-header');

            return $header->count() && false !== stripos($header->text(), 'prep time');
        });

        if (! $meta->count()) {
            return null;
        }

        return $this->extractString($meta, '.recipe-meta-item-body');
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
     * @param  mixed $value
     * @return mixed
     */
    protected function postNormalizeAuthor($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return trim($value, ',');
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    protected function postNormalizeDescription($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return trim(strip_tags($value));
    }
}
