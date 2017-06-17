<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * More thorough testing on url - there are two canonical links per page.
 * Look for recipes with ingredient groups to test.
 */
class WwwPaulaDeenCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.pauladeen.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
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
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-detail-wrapper .ingredients li');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-detail-wrapper .preparation p');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        // Other locations are inconsistent.
        return $this->extractString($crawler, '.breadcrumbs .product');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractTotalTime(Crawler $crawler)
    {
        // Not perfect - preptime and cooktime combined in the print view.
        return $this->extractString($crawler, '.prep-cook .data');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        // I don't like this... There are two canonical links, they don't always
        // match and one is generally invalid.
        $nodes = $crawler->filter('[rel="canonical"]');
        $value = $nodes->last()->attr('href') ?: '';

        return trim($value) ?: null;
    }
}
