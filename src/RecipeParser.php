<?php

namespace SSNepenthe\RecipeParser;

use SSNepenthe\RecipeParser\ParserLocator;
use SSNepenthe\RecipeParser\Interfaces\HttpClient;
use SSNepenthe\RecipeParser\Interfaces\CacheProvider;

class RecipeParser
{
    protected $cache;

    protected $client;

    public function __construct(HttpClient $client, CacheProvider $cache)
    {
        $this->cache  = $cache;
        $this->client = $client;
    }

    public function parse($url)
    {
        $html = $this->http_get_and_cache($url);

        $locator = new ParserLocator($url, $html);
        $located = $locator->locate();

        $parser = new $located($html);
        return $parser->parse();
    }

    protected function http_get_and_cache($url)
    {
        // Should we attempt to normalize the URL beforehand?
        if (! $response = $this->cache->fetch($url)) {
            $response = $this->client->get($url);

            $this->cache->save($url, $response, 60 * 60 * 24);
        }

        return $response;
    }
}
