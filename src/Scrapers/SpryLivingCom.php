<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * This site is powered by WordPress but at the time of this writing the recipe post
 * type is hidden from the REST API.
 */
class SpryLivingCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'spryliving.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, 'a[href*="recipes/category/"]');
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="cookTime"]', 'content');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[name="description"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '.main-image > img', 'data-lazy-src');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        // @todo Dedicated extractor?
        $nodes = $crawler->filter('[itemprop="ingredients"], .ingredients dt');

        if (! $nodes->count()) {
            return null;
        }

        $values = $nodes->each(function(Crawler $node) {
            $childNodes = $node->children();

            if (! $childNodes->count()) {
                return trim($node->text());
            }

            $subValues = $node->children()->each(function(Crawler $subNode) {
                return trim($subNode->text());
            });

            return implode(' ', array_filter($subValues));
        });

        return $values;
    }

    protected function extractInstructions(Crawler $crawler)
    {
        $selectors = [
            '[itemprop="recipeInstructions"] h4',
            '[itemprop="recipeInstructions"] li',
            '[itemprop="recipeInstructions"] strong',
        ];

        // @todo Dedicated extractor? See ingredients.
        $nodes = $crawler->filter(implode(', ', $selectors));

        if (! $nodes->count()) {
            return null;
        }

        $values = $nodes->each(function(Crawler $node) {
            $childNodes = $node->children();

            if (! $childNodes->count()) {
                return trim($node->text());
            }

            $subValues = $node->children()->each(function(Crawler $subNode) {
                return trim($subNode->text());
            });

            return implode(' ', array_filter($subValues));
        });

        return $values;
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
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
}
