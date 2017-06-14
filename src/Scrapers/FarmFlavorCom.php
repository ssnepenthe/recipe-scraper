<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

class FarmFlavorCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        $crawler = $this->preExtractionFilter($crawler);

        return parent::supports($crawler)
            && 'farmflavor.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '[property="article:tag"]', ['content']);
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="cookTime"] span');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="image"] [itemprop="url"]', ['content']);
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract(
                $crawler,
                '[itemprop="recipeIngredient"], .recipe-ingredients p'
            );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '[itemprop="recipeInstructions"] li');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, 'h1.entry-title');
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="prepTime"] span');
    }

    protected function extractPublisher(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract(
                $crawler,
                '[itemprop="publisher"] [itemprop="name"]',
                ['content']
            );
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', ['href']);
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="recipeYield"] span');
    }

    protected function preExtractionFilter(Crawler $crawler)
    {
        if (! $crawler->children()->count() && $crawler->siblings()->count()) {
            $crawler = $crawler->nextAll();
        }

        return $crawler;
    }
}
