<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Has nutrition information.
 *
 * Has links to other recipes in ingredients.
 *
 * Food and Wine prepends "Serves : " to the data we actually want from yield - should we trim it?
 *
 * Notes have headings which may be beneficial to include.
 *
 * Cooking Light (maybe others) have some blog-style posts with recipes, but no structured markup.
 *
 * We lose out on ingredient titles by using LD+JSON.
 *
 * @link https://www.timeinc.com/brands/
 *
 * @todo Consider extracting some sort of ->extractBodyBasedOnHeaderText() type method from times.
 *       Find cookinglight.com recipes with notes to test against (if any exist).
 */
class TimeInc extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @var string[]
     */
    protected $supportedHosts = [
        'www.cookinglight.com',
        'www.foodandwine.com',
        'www.myrecipes.com',
    ];

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && in_array(parse_url($crawler->getUri(), PHP_URL_HOST), $this->supportedHosts, true);
    }

    protected function extractCookTime(Crawler $crawler, array $json)
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
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // LD+JSON instructions are merged into single string. Could potentially extract list by
        // splitting on a double space, but probably easier to extract directly from body.
        $instructions = $crawler->filter('.recipe-instructions')->reduce(
            function (Crawler $node) : bool {
                $header = $node->filter('h3');

                // Returns true if this is not a notes section.
                return ! $header->count()
                    || ! preg_match('/(notes|suggested pairing|make ahead)/i', $header->text());
            }
        );

        if (! $instructions->count()) {
            return null;
        }

        return $this->extractArray($instructions, '.step p:last-child');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        $instructions = $crawler->filter('.recipe-instructions')->reduce(
            function (Crawler $node) : bool {
                $header = $node->filter('h3');

                return $header->count()
                    && 1 === preg_match('/(notes|suggested pairing|make ahead)/i', $header->text());
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
    protected function extractPrepTime(Crawler $crawler, array $json)
    {
        $meta = $crawler->filter('.recipe-meta-item')->reduce(function (Crawler $node) : bool {
            $header = $node->filter('.recipe-meta-item-header');

            return $header->count()
                && 1 === preg_match('/(prep|active|hands-on) time/i', $header->text());
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
    protected function extractUrl(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    protected function preNormalizeIngredients($value)
    {
        if (! Arr::ofStrings($value)) {
            return $value;
        }

        return array_map('strip_tags', $value);
    }
}
