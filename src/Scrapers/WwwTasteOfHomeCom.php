<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class WwwTasteOfHomeCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        // Lowercase "r".
        return $crawler->filter('[itemtype="http://schema.org/recipe"]')->count()
            && 'www.tasteofhome.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="author"] [itemprop="name"]', ['content']);
    }

    protected function extractDescription(Crawler $crawler)
    {
        // Incorrectly uses schema.org/recipe (with lowercase "r").
        return $this->extractString($crawler, '[itemprop="description"]');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="image"]', ['content']);
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] .rd_name');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="name"]', ['content']);
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    protected function extractYield(Crawler $crawler)
    {
        // Lowercase "y".
        return $this->extractString($crawler, '[itemprop="recipeyield"]');
    }
}
