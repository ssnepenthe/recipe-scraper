<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\SingularExtractor;

class WwwCookingChannelTvCom extends SchemaOrgJsonLd
{
    protected function extractAuthor(Crawler $crawler, array $json)
    {
        // Author is an array of person arrays.
        if (is_string($author = Arr::get($json, 'author.0.name'))) {
            return $author;
        }

        return null;
    }

    protected function extractCookTime(Crawler $crawler, array $json)
    {
        // There is a period between minutes and seconds.
        if (is_string($cookTime = Arr::get($json, 'cookTime'))) {
            return str_replace('.', '', $cookTime);
        }

        return null;
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        // Largest image is not available via LD+JSON.
        return (new SingularExtractor)
            ->extract($crawler, '[property="og:image"]', 'content');
    }

    protected function extractTotalTime(Crawler $crawler, array $json)
    {
        // There is a period between minutes and seconds.
        if (is_string($cookTime = Arr::get($json, 'totalTime'))) {
            return str_replace('.', '', $cookTime);
        }

        return null;
    }
}
