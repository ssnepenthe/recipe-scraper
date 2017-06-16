<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

/**
 * We lose ingredient titles by using LD+JSON.
 * Has notes if we want them.
 * Sometimes multiple instructions are getting merged into one in LD+JSON.
 */
class CookieAndKateCom extends SchemaOrgJsonLd
{
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'cookieandkate.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        // LD+JSON images are tiny.
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:image"]', ['content']);
    }
}
