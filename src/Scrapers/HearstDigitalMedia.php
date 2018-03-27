<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * May want to revisit notes. There is an "extra-content" section which has a lot of note-type
 * content, but is not included yet because the type of content is very inconsistent.
 *
 * Good Housekeeping LD+JSON is unreliable so that site gets dedicated scraper class.
 *
 * Latest migration seems to have resulted in some data loss - "⅓" character was removed entirely
 * instead of being converted to "1/3".
 *
 * Delish seems to be occasionally storing notes in the description field.
 *
 * Esquire seems to be using the description field to store the entire article text.
 *
 * @TODO Consider "ucwords" on extracted categories?
 *       Verify whether image extracted from LD+JSON is largest available - og:image may be better.
 */
class HearstDigitalMedia extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @var string[]
     */
    protected $supportedHosts = [
        'www.countryliving.com',
        'www.delish.com',
        'www.esquire.com',
        'www.goodhousekeeping.com',
        'www.redbookmag.com',
        'www.womansday.com',
    ];

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler) && in_array(
            parse_url($crawler->getUri(), PHP_URL_HOST),
            $this->supportedHosts,
            true
        );
    }

    protected function extractCategories(Crawler $crawler, array $json)
    {
        $categories = $this->extractString($crawler, 'meta[name="keywords"]', ['content']);

        if (! is_string($categories)) {
            return null;
        }

        return array_map('trim', explode(',', $categories));
    }

    protected function extractDescription(Crawler $crawler, array $json)
    {
        if (in_array(
            parse_url($crawler->getUri(), PHP_URL_HOST),
            ['www.esquire.com', 'www.goodhousekeeping.com'],
            true
        )) {
            return $this->extractString($crawler, '[name="description"]', ['content']);
        }

        return parent::extractDescription($crawler, $json);
    }

    protected function extractIngredients(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.ingredient-title, .ingredient-item');
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.direction-lists li');
    }

    protected function extractNotes(Crawler $crawler, array $json)
    {
        $selectors = ['.recipe-tips .tip', '.recipe-tips p', '.recipe-tips blockquote'];

        $notes = $this->extractArray($crawler, implode(',', $selectors));

        if (! is_array($notes)) {
            return null;
        }

        // Filter out nutrition data from www.womansday.com and www.goodhousekeeping.com.
        $notes = array_filter($notes, function ($note) {
            return false === stripos(trim($note), 'per serving');
        });

        return array_values($notes);
    }

    protected function preNormalizeDescription($value, Crawler $crawler)
    {
        if (! is_string($value)) {
            return null;
        }

        return strip_tags($value);
    }
}
