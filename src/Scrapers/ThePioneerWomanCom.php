<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use RecipeScraper\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Site is on WP.com so it has two REST APIs available... There is a lot of
 * information available but a lot of the recipe details seem to be missing.
 *
 * @link https://vip.wordpress.com/documentation/api/
 *
 * Many recipes have notes but they are bundled in with instructions.
 */
class ThePioneerWomanCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'thepioneerwoman.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="author"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '.entry-content > p:first-of-type');
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
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  string[]|null $value
     * @param  Crawler       $crawler
     * @return string[]|null
     */
    protected function preNormalizeInstructions($value, Crawler $crawler)
    {
        if (is_null($value) || ! Arr::ofStrings($value)) {
            return $value;
        }

        $newInstructions = [];

        foreach ($value as $instruction) {
            $newInstructions = array_merge($newInstructions, Str::lines($instruction));
        }

        return $newInstructions;
    }
}
