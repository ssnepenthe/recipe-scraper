<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Timestamps don't seem to match the displayed counterparts but displayed text isn't
 * always in a format that DateInterval::createFromDateString() understands.
 *
 * Sometimes includes links to other recipes in ingredients section.
 *
 * I have found some recipes with notes but they all seem to be bundled in with instructions.
 */
class EmerilsCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'emerils.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-tags a');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCuisines(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.detail-cuisine a');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        // Has itemprop="description" but something weird in the markup...
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="image"] img', ['data-original']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        if ($crawler->filter('.page-section-directions p')->count()) {
            return $this->extractArray($crawler, '.page-section-directions p');
        }

        return $this->extractArray($crawler, '.page-section-directions li');
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
        return $this->extractString($crawler, '.meta-yield');
    }
}
