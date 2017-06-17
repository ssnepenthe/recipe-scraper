<?php

namespace RecipeScraper\Scrapers;

use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

class ScrippsNetworks extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        $host = parse_url($crawler->getUri(), PHP_URL_HOST);

        return parent::supports($crawler) && (
            'www.cookingchanneltv.com' === $host || 'www.foodnetwork.com' === $host
        );
    }

    /**
     * @param  Crawler $crawler
     * @param  array $json
     * @return string|null
     */
    protected function extractImage(Crawler $crawler, array $json)
    {
        // Largest image is not available via LD+JSON.
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function preNormalizeCookTime($value)
    {
        return $this->stripPeriodFromIntervalString($value);
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function preNormalizeTotalTime($value)
    {
        return $this->stripPeriodFromIntervalString($value);
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function stripPeriodFromIntervalString($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return (string) s($value)->replace('.', '');
    }
}
