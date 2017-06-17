<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * FYI there is a JSON API if you send header 'Accept: application/json'.
 * They have nutrition info if we ever want it.
 */
class WwwBhgCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.bhg.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCookingMethod(Crawler $crawler)
    {
        // Cooking method itemprop is used on cooktimes...
        return null;
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '.recipe__image', ['content']);
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArrayFromChildren($crawler, '[itemprop="recipeIngredient"]');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe__direction, .recipe__instructionGroupHeader');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, 'h1[itemprop="name"]');
    }
}
