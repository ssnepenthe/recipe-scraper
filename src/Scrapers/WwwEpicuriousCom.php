<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Sometimes notes are bundled in with instructions...
 * Also has nutrition info if we want it.
 */
class WwwEpicuriousCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.epicurious.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
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
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="image"]',
            ['content']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.ingredient-group strong, [itemprop="ingredients"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.preparation-group strong, .preparation-step');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        // @todo More testing!
        return $this->extractArray($crawler, '.chef-notes-content');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="url"]',
            ['content']
        );
    }
}
