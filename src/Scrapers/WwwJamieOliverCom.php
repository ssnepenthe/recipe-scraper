<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Lose out on ingredient and instruction group titles by using LD+JSON.
 * (eg - https://www.jamieoliver.com/recipes/seafood-recipes/alesha-dixon-s-spicy-prawns/)
 *
 * Some recipes return cuisines
 * - is a schema.org url (eg 'https://schema.org/VegetarianDiet')
 * - cuisine = diatary category in JO's world. Vegan/GlutenFree etc
 * No Cooking Method seen
 * No Notes seen
 * Sporadic use of cookTime, prepTime & totalTime
 *
 * Description data, should sometimes be placed into notes,
 * - hard to distinguish when (same URL as above)
 *
 * Mixing blog 'tags' with the json-defined categories.
 */
class WwwJamieOliverCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    public function __construct()
    {
        // Add nameSub to the $properties array
        // JamieOliver has a short description after the name
        array_push($this->properties, 'nameSub');
    }

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.jamieoliver.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler, array $json)
    {
        $categories = array_values(array_filter(array_merge(
            [Arr::get($json, 'recipeCategory')],
            $this->extractArray($crawler, '[class="tags-list"] a') ?: []
        )));

        return empty($categories) ? null : $categories;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // Instructions within JSON have HTML tags, avoiding them
        $selectors = [
            '[class="recipeSteps"] li',
        ];

        return $this->extractArray($crawler, implode(', ', $selectors));
    }

    protected function extractNameSub(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[class="subheading"]');
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
