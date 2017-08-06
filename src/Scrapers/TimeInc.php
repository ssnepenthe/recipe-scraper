<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Has JSON LD but with very limited subset of data.
 *
 * Has nutrition information.
 *
 * Has links to other recipes in ingredients.
 *
 * Food and Wine prepends "Serves : " to the data we actually want from yield - should we trim it?
 *
 * Could use some more thorough testing on description.
 *
 * Notes have headings which may be beneficial to include.
 *
 * Cooking Light (maybe others) have some blog-style posts with recipes, but no structured markup.
 *
 * @link https://www.timeinc.com/brands/
 *
 * @todo Consider updating parent supports method to not be dependent on scheme.
 *       Consider extracting some sort of ->extractBodyBasedOnHeaderText() type method from times.
 *       Find cookinglight.com recipes with notes to test against (if any exist).
 */
class TimeInc extends SchemaOrgMarkup
{
    protected $supportedHosts = [
        'www.cookinglight.com',
        'www.foodandwine.com',
        'www.myrecipes.com',
    ];

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        // Consider pushing "*=" selector up to parent class.
        return (bool) $crawler->filter('[itemtype*="schema.org/Recipe"]')->count()
            && in_array(parse_url($crawler->getUri(), PHP_URL_HOST), $this->supportedHosts, true);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="https://schema.org/Recipe"] [itemprop="author"] [itemprop="name"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractCookTime(Crawler $crawler)
    {
        $meta = $crawler->filter('.recipe-meta-item')->reduce(function (Crawler $node) : bool {
            $header = $node->filter('.recipe-meta-item-header');

            return $header->count() && false !== stripos($header->text(), 'cook time');
        });

        if (! $meta->count()) {
            return null;
        }

        return $this->extractString($meta, '.recipe-meta-item-body');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        // [name="description"] and [property="og:description"] are truncated.
        // Food and Wine seems to add category, slideshow or similar links to end of description.
        return $this->extractString($crawler, '.schema [itemprop="description"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="https://schema.org/Recipe"] [itemprop="image"]',
            ['content', 'data-src']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        // To include group headers.
        $selectors = [
            '.ingredients h2',
            '[itemprop="recipeIngredient"]',
            '[itemprop="ingredients"]',
        ];

        return $this->extractArray($crawler, implode(', ', $selectors));
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"] p:last-child');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString($crawler, '.schema [itemprop="name"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        $instructions = $crawler->filter('.recipe-instructions')->reduce(
            function (Crawler $node) : bool {
                $header = $node->filter('h3');

                return $header->count()
                    && 1 === preg_match('/(notes|suggested pairing|make ahead)/i', $header->text());
            }
        );

        if (! $instructions->count()) {
            return null;
        }

        return $this->extractArray($instructions, '.step');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPrepTime(Crawler $crawler)
    {
        $meta = $crawler->filter('.recipe-meta-item')->reduce(function (Crawler $node) : bool {
            $header = $node->filter('.recipe-meta-item-header');

            return $header->count()
                && 1 === preg_match('/(prep|active|hands-on) time/i', $header->text());
        });

        if (! $meta->count()) {
            return null;
        }

        return $this->extractString($meta, '.recipe-meta-item-body');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    protected function postNormalizeAuthor($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return trim($value, ',');
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    protected function preNormalizeDescription($value)
    {
        // Pre normalize so that we still collapse whitespace after stripping tags.
        if (! is_string($value)) {
            return $value;
        }

        return strip_tags($value);
    }
}
