<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class WwwFarmFlavorCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        $crawler = $this->preExtractionFilter($crawler);

        return parent::supports($crawler)
            && 'www.farmflavor.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[property="article:tag"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractCookTime(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="cookTime"] span');
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
        return $this->extractArray(
            $crawler,
            '[itemprop="recipeIngredient"], .recipe-ingredients p'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, 'h1.entry-title');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-tips p');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="prepTime"] span');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPublisher(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="publisher"] [itemprop="name"]',
            ['content']
        );
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
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractYield(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="recipeYield"] span');
    }

    /**
     * @param  Crawler $crawler
     * @return Crawler
     */
    protected function preExtractionFilter(Crawler $crawler) : Crawler
    {
        if (! $crawler->children()->count() && $crawler->siblings()->count()) {
            $crawler = $crawler->nextAll();
        }

        return $crawler;
    }
}
