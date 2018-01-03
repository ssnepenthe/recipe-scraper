<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class AllRecipesCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'allrecipes.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, 'meta[itemprop="recipeCategory"]', ["content"]);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, 'div[itemprop="description"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, 'h1[itemprop="name"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        // Get footnote list items and remove headers.
        // @todo Find more recipes to test against!
        $crawler = $crawler->filter('.recipe-footnotes li')
            ->reduce(function (Crawler $node) : bool {
                return ! $node->filter('.recipe-footnotes__header')->count();
            });

        return $this->extractArray($crawler);
    }
}
