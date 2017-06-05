<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\SingularExtractor;

/**
 * Site is a scripps networks site - may be able to combine into single scraper.
 */
class WwwFoodNetworkCom extends SchemaOrgJsonLd
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.foodnetwork.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        // Largest image is not available via LD+JSON.
        return (new SingularExtractor)
            ->extract($crawler, '[property="og:image"]', 'content');
    }

    protected function preNormalizeCookTime($value)
    {
        return $this->stripPeriodFromIntervalString($value);
    }

    protected function preNormalizeTotalTime($value)
    {
        return $this->stripPeriodFromIntervalString($value);
    }

    protected function stripPeriodFromIntervalString($value)
    {
        return (string) s($value)->replace('.', '');
    }
}
