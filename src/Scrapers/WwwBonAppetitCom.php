<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * We lose out on ingredient group titles by using LD+JSON.
 *
 * Has notes but they are stuffed in with instructions.
 */
class WwwBonAppetitCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.bonappetit.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler, array $json)
    {
        // Seems to include author, company, city and state. Also used for photo credit...
        return $this->extractString($crawler, '.recipe__credits + span');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler, array $json)
    {
        // May not all be appropriate... Seems to include ingredients, course, etc.
        return $this->extractArray($crawler, '.keyword');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // @todo 17 July 2017: it looks like they made some updates but forgot about ld+json...
        // This should be revisited over the next few weeks to see if they have restored it.
        return $this->extractArray($crawler, '.preparation__hed, .preparation__step');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
