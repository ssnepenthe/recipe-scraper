<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Occasionally includes links to other recipes in ingredients section
 * Has keywords available which could potentially be used as extra categories.
 * Also has a "variations" section.
 */
class WwwMarthaStewartCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.marthastewart.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.notes-cooks .note-text');
    }

    protected function preNormalizeIngredients($value)
    {
        if (! Arr::ofStrings($value)) {
            return $value;
        }

        return array_map('strip_tags', $value);
    }
}
