<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\Plural;
use SSNepenthe\RecipeScraper\Extractors\Singular;

/**
 * More thorough testing on url - there are two canonical links per page.
 * Look for recipes with ingredient groups to test.
 */
class WwwPaulaDeenCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.pauladeen.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[name="description"]', 'content');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.recipe-detail-wrapper .ingredients li');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.recipe-detail-wrapper .preparation p');
    }

    protected function extractName(Crawler $crawler)
    {
        // Other locations are inconsistent.
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.breadcrumbs .product');
    }

    protected function extractTotalTime(Crawler $crawler)
    {
        // Not perfect - preptime and cooktime combined in the print view.
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.prep-cook .data');
    }

    protected function extractUrl(Crawler $crawler)
    {
        // I don't like this... There are two canonical links, they don't always
        // match and one is generally invalid.
        $nodes = $crawler->filter('[rel="canonical"]');

        return $nodes->count() ? trim($nodes->last()->attr('href')) : null;
    }
}
