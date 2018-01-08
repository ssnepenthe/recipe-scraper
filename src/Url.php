<?php

namespace RecipeScraper;

use Symfony\Component\DomCrawler\Crawler;

class Url
{
    /**
     * @param  string  $url
     * @param  Crawler $crawler
     * @return string
     */
    public static function relativeToAbsolute(string $url, Crawler $crawler)
    {
        if ('//' !== substr($url, 0, 2)) {
            return $url;
        }

        if (! $uri = $crawler->getUri()) {
            return $url;
        }

        return parse_url($uri, PHP_URL_SCHEME) . ':' . $url;
    }
}
