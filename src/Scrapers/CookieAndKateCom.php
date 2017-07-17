<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * We lose ingredient titles by using LD+JSON.
 * Sometimes multiple instructions are getting merged into one in LD+JSON.
 */
class CookieAndKateCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'cookieandkate.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractImage(Crawler $crawler, array $json)
    {
        // LD+JSON images are tiny.
        return $this->extractString($crawler, '[property="og:image"]', ['content']);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        // Notes are very inconsistent. This could use a lot more testing.
        if (! is_null($divs = $this->extractArray($crawler, '.tasty-recipes-notes div'))) {
            // Notes are split into individual div elements.
            return $divs;
        }

        $crawler = $crawler->filter('.tasty-recipes-notes p');

        if (! $crawler->count()) {
            return null;
        }

        $ps = $this->extractArray($crawler);

        if (! is_null($ps) && 1 < count($ps)) {
            // Notes are split into individual paragraph elements.
            return $ps;
        }

        if (! $first = $crawler->getNode(0)) {
            return null;
        }

        $notes = [];
        $value = '';

        // Down to native DOM API.
        foreach ($first->childNodes as $childNode) {
            // Notes are in one paragraph element split by line breaks.
            if (XML_TEXT_NODE === $childNode->nodeType) {
                $value .= $childNode->wholeText;
            } elseif (XML_ELEMENT_NODE === $childNode->nodeType) {
                if ('em' === $childNode->nodeName) {
                    // If <em> it is likely an "adapted from..." note. May want to revisit this
                    // since it would actually be nice to have, but means preserving the link.
                    continue;
                }

                if ('br' === $childNode->nodeName) {
                    // If <br> it means we are ready to move to the next note.
                    $notes[] = $value;
                    $value = '';
                } else {
                    $value .= $childNode->nodeValue;
                }
            }
        }

        // Flush any lingering value to the notes array.
        if (! empty($value)) {
            $notes[] = $value;
            $value = '';
        }

        return $notes;
    }
}
