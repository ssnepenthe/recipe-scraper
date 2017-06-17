<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Has LD+JSON but with a very limited subset of data.
 *
 * Could use some more thorough testing on description.
 */
class WwwFoodAndWineCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.foodandwine.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="author"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="description"] p:first-child');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.ingredients-list__title, [itemprop="ingredients"]');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, 'h1[itemprop="name"]');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
