<?php

namespace SSNepenthe\RecipeScraper;

use GuzzleHttp\HandlerStack;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Doctrine\Common\Cache\FilesystemCache;
use SSNepenthe\RecipeScraper\ScraperLocator;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;

class Client extends GoutteClient
{
    public function scrape($url)
    {
        $crawler = $this->request('GET', $url);

        $locator = new ScraperLocator($crawler);
        $located = $locator->locate();

        $scraper = new $located($crawler);

        return $scraper->scrape();
    }

    public function enableGreedyFileCache($dir = '.cache', $lifeTime = 60 * 60 * 24)
    {
        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(
            new GreedyCacheStrategy(
                new DoctrineCacheStorage(
                    new FilesystemCache($dir)
                ),
                $lifeTime
            )
        ), 'cache');

        $guzzle = new GuzzleClient([
            'handler' => $stack
        ]);

        $this->setClient($guzzle);
    }
}
