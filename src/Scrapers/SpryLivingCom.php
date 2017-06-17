<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * This site is powered by WordPress but at the time of this writing the recipe post
 * type is hidden from the REST API.
 */
class SpryLivingCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'spryliving.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, 'a[href*="recipes/category/"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '.main-image > img', ['data-lazy-src']);
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArrayFromChildren(
            $crawler,
            '[itemprop="ingredients"], .ingredients dt'
        );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        $selectors = [
            '[itemprop="recipeInstructions"] h4',
            '[itemprop="recipeInstructions"] li',
            '[itemprop="recipeInstructions"] strong',
        ];

        return $this->extractArrayFromChildren($crawler, implode(', ', $selectors));
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
