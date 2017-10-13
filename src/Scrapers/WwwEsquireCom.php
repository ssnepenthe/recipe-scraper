<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

class WwwEsquireCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.esquire.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractAuthor(Crawler $crawler, array $json)
    {
        $author = parent::extractAuthor($crawler, $json);

        if ($author) {
            return $author;
        }

        // Sometimes we get a blank string from LD+JSON, so let's fallback to microdata markup.
        return $this->extractString($crawler, '[itemprop="author"] [itemprop="name"]');
    }

    protected function extractDescription(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    protected function extractIngredients(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.ingredient-title, .ingredient-item');
    }

    protected function extractInstructions(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.directions li');
    }

    protected function extractNotes(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.recipe-tips p, .recipe-tips blockquote');
    }
}
