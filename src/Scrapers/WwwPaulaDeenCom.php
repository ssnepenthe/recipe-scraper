<?php

namespace RecipeScraper\Scrapers;

use function Stringy\create as s;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Look for recipes with ingredient groups to test.
 *
 * The only notes I have found are bundled in with instructions.
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

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString($crawler, '[name="description"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-detail-wrapper .ingredients li');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '.recipe-detail-wrapper .preparation p');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        // Other locations are inconsistent.
        return $this->extractString($crawler, '.breadcrumbs .product');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractTotalTime(Crawler $crawler)
    {
        // Not perfect - preptime and cooktime combined in the print view.
        return $this->extractString($crawler, '.prep-cook .data');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        // Could use some more thorough testing. It looks like there are always two canonical links
        // for a recipe. The bad canonical *seems* to always be the first in the page and doesn't
        // end with a trailing "/". Not sure what would be the best check to perform here...
        $crawler = $crawler->filter('[rel="canonical"]')->reduce(function (Crawler $node) : bool {
            return $node->count() ? s($node->attr('href'))->endsWith('/') : false;
        });

        if (! $crawler->count() || ! $href = $crawler->attr('href')) {
            return null;
        }

        return trim($href) ?: null;
    }
}
