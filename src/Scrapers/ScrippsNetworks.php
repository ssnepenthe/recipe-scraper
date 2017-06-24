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

        // DateInterval doesn't play well with fractions of seconds in ISO8601 interval strings.
        // All recipes I have reviewed don't use time measurements smaller than minutes.
        // So this converts something like P0Y0M0DT0H35M0.000S to P0Y0M0DT0H35M0S.
        return (string) s($value)->regexReplace('(\d{1,2})\.\d{3}S', '\\1S');
    }
}
