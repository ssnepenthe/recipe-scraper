<?php

namespace RecipeScraper\Scrapers;

use Stringy\Stringy;
use RecipeScraper\Arr;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Lose out on ingredient and instruction group titles by using LD+JSON.
 * (eg - https://www.jamieoliver.com/recipes/seafood-recipes/alesha-dixon-s-spicy-prawns/)
 *
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
            $this->extractArray($crawler, '.tags-list a') ?: []
        )));

        return empty($categories) ? null : $categories;
    }

    protected function extractCuisines(Crawler $crawler, array $json)
    {
        $json = parent::extractCuisines($crawler, $json) ?: [];
        $markup = $this->extractArray($crawler, '.special-diets-list .full-name') ?: [];

        $cuisines = array_unique(array_filter(array_merge($json, $markup), function ($cuisine) {
            return false === strpos($cuisine, 'schema.org');
        }));

        return empty($cuisines) ? null : $cuisines;
    }

    protected function extractIngredients(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.ingred-list li');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // Instructions within JSON have HTML tags, avoiding them
        return $this->extractArray($crawler, '.recipeSteps li');
    }

    protected function extractNameSub(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '.subheading');
    }

    protected function extractNotes(Crawler $crawler, array $json)
    {
        // @todo Needs further testing...
        return $this->extractArray($crawler, '.instructions-wrapper > p');
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

    protected function postNormalizeIngredients($value, Crawler $crawler)
    {
        if (! Arr::ofStrings($value)) {
            return null;
        }

        return array_map(function ($ingredient) {
            // Note/descriptor is appended with leading " , " - let's remove that front space.
            return (string) Stringy::create($ingredient)
                ->regexReplace('[[:space:]]+,[[:space:]]+', ', ');
        }, $value);
    }
}
