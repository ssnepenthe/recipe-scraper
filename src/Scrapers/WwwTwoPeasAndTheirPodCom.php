<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Can potentially switch to name="description" for description but it isn't always that great...
 *
 * Some recipes include links to other recipes in their ingredients list.
 *
 * Has some malformed intervals...
 * See https://www.twopeasandtheirpod.com/banana-cupcakes-with-cream-cheese-frosting-sweet-designs-giveaway/
 */
class WwwTwoPeasAndTheirPodCom extends SchemaOrgJsonLd
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.twopeasandtheirpod.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler, array $json)
    {
        // WordPress tags - may not all be appropriate.
        return $this->extractArray($crawler, '[rel~="tag"]');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler, array $json)
    {
        // Tags are stripped from LD+JSON, which means partial content when there is a link.
        // See https://www.twopeasandtheirpod.com/3-ingredient-peanut-butter-hot-fudge/.
        $selectors = [
            '[itemprop="ingredients"]',
            '.ingredients h4',
            '.ingredients li',
            '.ingredients p',
        ];

        return $this->extractArray($crawler, implode(', ', $selectors));
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // LD+JSON instructions are merged into one.
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] li');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractName(Crawler $crawler, array $json)
    {
        // LD+JSON may include "Recipe for " prefix or similar.
        return $this->extractString($crawler, '[itemprop="name"]', ['_text', 'content']);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        // @todo More testing!
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] p');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        // Has itemprop="url" but it is missing trailing slash.
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
