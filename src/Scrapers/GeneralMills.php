<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Extractors\PluralFromChildren;

/**
 * Can potentially get categories off of data-category attribute on ingredients.
 * Nutrition info is there if we want it as well.
 * There are also notes/tips.
 */
class GeneralMills extends SchemaOrgMarkup
{
    protected $supportedHosts = [
        'www.bettycrocker.com',
        'www.pillsbury.com',
        'www.tablespoon.com',
    ];

    public function supports(Crawler $crawler) : bool
    {
        $host = parse_url($crawler->getUri(), PHP_URL_HOST);

        return in_array($host, $this->supportedHosts, true);
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.contributorPage');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:image"]', ['content']);
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

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', ['href']);
    }
}
