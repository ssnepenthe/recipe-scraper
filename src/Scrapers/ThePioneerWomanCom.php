<?php

namespace RecipeScraper\Scrapers;

use function Stringy\create as s;
use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Site is on WP.com so it has two REST APIs available... There is a lot of
 * information available but a lot of the recipe details seem to be missing.
 *
 * @link https://vip.wordpress.com/documentation/api/
 */
class ThePioneerWomanCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'thepioneerwoman.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="author"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.entry-content > p:first-of-type');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:image"]', ['content']);
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', ['href']);
    }

    protected function preNormalizeInstructions($value)
    {
        if (! is_array($value)) {
            return $value;
        }

        $newInstructions = [];

        foreach ($value as $instruction) {
            $newInstructions = array_merge(
                $newInstructions,
                array_map('strval', s($instruction)->lines())
            );
        }

        return $newInstructions;
    }
}
