<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class WwwGoodHousekeepingCom extends HearstDigitalMedia
{
    protected $supportedHosts = ['www.goodhousekeeping.com'];

    public function supports(Crawler $crawler) : bool
    {
        // Occasionally running into malformed JSON so we can't reliably use that as an indicator.
        // @see http://www.goodhousekeeping.com/food-recipes/easy/a44227/sweet-potato-avocado-black-bean-tacos-recipe/
        return in_array(parse_url($crawler->getUri(), PHP_URL_HOST), $this->supportedHosts, true);
    }

    protected function extractAuthor(Crawler $crawler, array $json)
    {
        $author = parent::extractAuthor($crawler, $json);

        if (! $author) {
            $author = $this->extractString($crawler, '[rel="author"] [itemprop="name"]');
        }

        return $author;
    }

    protected function extractDescription(Crawler $crawler, array $json)
    {
        $description = parent::extractDescription($crawler, $json);

        if (! $description) {
            $description = $this->extractString($crawler, '[name="description"]', ['content']);
        }

        return $description;
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }

    protected function extractIngredients(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '[itemprop="ingredients"]');
    }

    protected function extractInstructions(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
    }

    protected function extractName(Crawler $crawler, array $json)
    {
        $name = parent::extractName($crawler, $json);

        if (! $name) {
            // Or itemprop="name"...
            $name = $this->extractString($crawler, '.article-title');
        }

        return $name;
    }

    protected function extractPrepTime(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[itemprop="prepTime"]', ['datetime']);
    }

    protected function extractTotalTime(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[itemprop="totalTime"]', ['datetime']);
    }

    protected function extractUrl(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    protected function extractYield(Crawler $crawler, array $json)
    {
        // Remove label (serves:, yield:, etc.) and trim resultant string.
        $yield = $this->extractString($crawler, '[itemprop="recipeYield"]');

        if (! is_string($yield)) {
            return null;
        }

        $label = $this->extractString($crawler, '[itemprop="recipeYield"] .recipe-info-label');

        return trim(str_replace(($label ?: ''), '', $yield));
    }
}
