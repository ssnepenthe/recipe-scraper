<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * We lose ingredient titles by using LD+JSON.
 * Has notes if we want them.
 * Sometimes multiple instructions are getting merged into one in LD+JSON.
 */
class CookieAndKateCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'cookieandkate.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractImage(Crawler $crawler, array $json)
    {
        // LD+JSON images are tiny.
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }
}
