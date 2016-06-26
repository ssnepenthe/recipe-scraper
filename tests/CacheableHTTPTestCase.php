<?php

use SSNepenthe\RecipeParser\Cache\DoctrineFSCache;
use SSNepenthe\RecipeParser\Http\CurlClient;

class CacheableHTTPTestCase extends PHPUnit_Framework_TestCase
{
    protected $cache;
    protected $http;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->cache = new DoctrineFSCache(sprintf(
            '%s/.cache',
            dirname(__DIR__)
        ));

        $this->http = new CurlClient;
    }

    protected function get_and_cache($url)
    {
        if (! $html = $this->cache->fetch($url)) {
            $html = $this->http->get($url);

            $this->cache->save($url, $html, 60 * 60 * 24 * 5);
        }

        return $html;
    }
}
