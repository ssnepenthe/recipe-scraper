<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Can potentially get categories off of data-category attribute on ingredients.
 * Nutrition info is there if we want it as well.
 * There are also notes/tips.
 */
class GeneralMills extends SchemaOrgMarkup
{
    /**
     * @var string[]
     */
    protected $supportedHosts = [
        'www.bettycrocker.com',
        'www.pillsbury.com',
        'www.tablespoon.com',
    ];

    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler) && in_array(
            parse_url($crawler->getUri(), PHP_URL_HOST),
            $this->supportedHosts,
            true
        );
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '.contributorPage');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[property="og:description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArrayFromChildren(
            $crawler,
            '.recipePartIngredientGroup h2, .recipePartIngredient'
        );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipePartStepDescription');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
