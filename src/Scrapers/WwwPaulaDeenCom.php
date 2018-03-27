<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Look for recipes with ingredient groups to test.
 *
 * The only notes I have found are bundled in with instructions.
 *
 * @todo Times are all jacked... Prep is tagged cook and cook is untagged.
 */
class WwwPaulaDeenCom extends SchemaOrgMarkup
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.pauladeen.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.tags a');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="image"] [itemprop="contentUrl"]',
            ['src']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.directions__content p');
    }

    protected function extractYield(Crawler $crawler)
    {
        $yield = $this->extractString($crawler, '[itemprop="recipeYield"]');

        if (! is_string($yield)) {
            return null;
        }

        $label = $this->extractString($crawler, '[itemprop="recipeYield"] b');

        return trim(str_replace(($label ?: ''), '', $yield));
    }
}
