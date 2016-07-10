<?php

use GuzzleHttp\HandlerStack;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Doctrine\Common\Cache\FilesystemCache;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;

class CachedHTTPTestCase extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $cache_dir = dirname(__DIR__) . '/.cache';

        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(
            new GreedyCacheStrategy(
                new DoctrineCacheStorage(
                    new FilesystemCache('.cache')
                )
            , 60 * 60 * 24)
        ), 'cache');

        $guzzle = new GuzzleClient(['handler' => $stack]);

        $this->client = new GoutteClient;
        $this->client->setClient($guzzle);
    }
}
