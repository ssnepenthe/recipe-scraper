<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * We lose ingredient titles by using LD+JSON.
 *
 * Sometimes multiple instructions are getting merged into one in LD+JSON.
 *
 * @todo Find recipe w/o notes to test against.
 *       Consider stepping away from json ld for ingredients.
 */
class CookieAndKateCom extends SchemaOrgJsonLd
{
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
        // Notes are inconsistent. This could use a lot more testing.
        if (! is_null($divs = $this->extractArray($crawler, '.tasty-recipes-notes div'))) {
            // Notes are split into individual div elements.
            return $divs;
        }

        // Down to native DOM API we go...
        $notes = $crawler->filter('.tasty-recipes-notes p')->each(function (Crawler $node) : array {
            if (! $first = $node->getNode(0)) {
                return [];
            }

            $values = [];
            $current = '';

            foreach ($first->childNodes as $childNode) {
                // Notes are in a paragraph element split by line breaks.
                if (XML_TEXT_NODE === $childNode->nodeType) {
                    $current .= $childNode->wholeText;
                } elseif (XML_ELEMENT_NODE === $childNode->nodeType) {
                    if ('em' === $childNode->nodeName) {
                        // If <em> it is likely an "adapted from..." note. May want to revisit this
                        // since it would actually be nice to have, but means preserving the link.
                        continue;
                    }

                    if ('br' === $childNode->nodeName) {
                        // If <br> it means we are ready to move to the next note.
                        $values[] = $current;
                        $current = '';
                    } else {
                        $current .= $childNode->nodeValue;
                    }
                }
            }

            // Flush any lingering current value to the values array.
            if (! empty($current)) {
                $values[] = $current;
                $current = '';
            }

            return array_filter(
                $values,
                /**
                 * @param  string $value
                 * @return bool
                 */
                function (string $value) : bool {
                    // These notes are mostly links to category pages and books.
                    return false === stripos($value, 'if you love this recipe');
                }
            );
        });

        // @todo Verify array is not empty?

        return call_user_func_array('array_merge', $notes);
    }
}
