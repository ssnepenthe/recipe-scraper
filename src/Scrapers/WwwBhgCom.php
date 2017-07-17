<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * FYI there is a JSON API if you send header 'Accept: application/json'.
 * They have nutrition info if we ever want it.
 *
 * Times are often mis-labeled or missing itemprop completely.
 */
class WwwBhgCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.bhg.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return null
     */
    protected function extractCookingMethod(Crawler $crawler)
    {
        // Cooking method itemprop is used on cooktimes...
        return null;
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="image"] [itemprop="url"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArrayFromChildren($crawler, '[itemprop="recipeIngredient"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe__direction, .recipe__instructionGroupHeader');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, 'h1[itemprop="name"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe__tip');
    }
}
