<?php

namespace RecipeScraper;

use Symfony\Component\DomCrawler\Crawler;

trait ExtractsDataFromCrawler
{
    /**
     * @param  Crawler  $crawler
     * @param  string   $selector
     * @param  string[] $attrs
     * @return string[]|null
     */
    protected function extractArray(Crawler $crawler, string $selector, array $attrs = ['_text'])
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        $values = array_filter($nodes->each(
            /**
             * @param Crawler $node
             * @return string|null
             */
            function (Crawler $node) use ($attrs) {
                foreach ($attrs as $attr) {
                    if ('_text' === $attr && $value = trim($node->text())) {
                        return $value;
                    }

                    if ($value = trim($node->attr($attr) ?: '')) {
                        return $value;
                    }
                }

                return null;
            }
        ));

        return count($values) ? array_values($values) : null;
    }

    /**
     * @param  Crawler  $crawler
     * @param  string   $selector
     * @param  string[] $attrs
     * @return string[]|null
     */
    protected function extractArrayFromChildren(
        Crawler $crawler,
        string $selector,
        array $attrs = ['_text']
    ) {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        $values = array_filter($nodes->each(
            /**
             * @param Crawler $node
             * @return string|null
             */
            function (Crawler $node) use ($attrs) {
                $childNodes = $node->children();

                if (! $childNodes->count()) {
                    foreach ($attrs as $attr) {
                        if ('_text' === $attr && $value = trim($node->text())) {
                            return $value;
                        }

                        if ($value = trim($node->attr($attr) ?: '')) {
                            return $value;
                        }
                    }

                    return null;
                }

                $subValues = array_filter($childNodes->each(
                    /**
                     * @param Crawler $subNode
                     * @return string|null
                     */
                    function (Crawler $subNode) use ($attrs) {
                        foreach ($attrs as $attr) {
                            if ('_text' === $attr && $value = trim($subNode->text())) {
                                return $value;
                            }

                            if ($value = trim($subNode->attr($attr) ?: '')) {
                                return $value;
                            }
                        }

                        return null;
                    }
                ));

                return implode(' ', $subValues);
            }
        ));

        return count($values) ? array_values($values) : null;
    }

    /**
     * @param  Crawler  $crawler
     * @param  string   $selector
     * @param  string[] $attrs
     * @return string|null
     */
    protected function extractString(Crawler $crawler, string $selector, array $attrs = ['_text'])
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        foreach ($attrs as $attr) {
            if ('_text' === $attr && $value = trim($nodes->text())) {
                return $value;
            }

            if ($value = trim($nodes->attr($attr) ?: '')) {
                return $value;
            }
        }

        return null;
    }
}
