<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\Plural;
use SSNepenthe\RecipeScraper\Extractors\Singular;

/**
 * @todo  Has notes if we want them.
 */
class AllRecipesCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'allrecipes.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, 'div[itemprop="description"]');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '[itemprop="recipeInstructions"] li');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, 'h1[itemprop="name"]');
    }
}
