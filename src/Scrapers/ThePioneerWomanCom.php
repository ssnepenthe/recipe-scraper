<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use function Stringy\create as s;
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
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[rel="author"]');
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="cookTime"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '.entry-content > p:first-of-type');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[property="og:image"]', 'content');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '[itemprop="ingredients"]');
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[rel="canonical"]', 'href');
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeYield"]');
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
