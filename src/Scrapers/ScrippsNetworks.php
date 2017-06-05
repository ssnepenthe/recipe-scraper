<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\Singular;

class ScrippsNetworks extends SchemaOrgJsonLd
{
    public function supports(Crawler $crawler) : bool
    {
        $host = parse_url($crawler->getUri(), PHP_URL_HOST);

        return 'www.cookingchanneltv.com' === $host
            || 'www.foodnetwork.com' === $host;
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        // Largest image is not available via LD+JSON.
        return $this->extractor->make(Singular::class)
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
