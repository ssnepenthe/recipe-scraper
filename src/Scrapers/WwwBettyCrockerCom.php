<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\Plural;
use SSNepenthe\RecipeScraper\Extractors\Singular;
use SSNepenthe\RecipeScraper\Extractors\PluralFromChildren;

/**
 * Can potentially get categories off of data-category attribute on ingredients.
 * Nutrition info is there if we want it as well.
 * There are also notes/tips.
 *
 * Bettycrocker.com is a General Mills operated site. Might be able to merge all of
 * them into a single scraper.
 */
class WwwBettyCrockerCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.bettycrocker.com' === parse_url(
            $crawler->getUri(),
            PHP_URL_HOST
        );
    }

    public function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:description"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:image"]', 'content');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractor->make(PluralFromChildren::class)
            ->extract(
                $crawler,
                '.recipePartIngredientGroup h2, .recipePartIngredientGroup dl'
            );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.recipePartStepDescription');
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
    }

    protected function extractTotalTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="totalTime"]', 'content');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', 'href');
    }
}
