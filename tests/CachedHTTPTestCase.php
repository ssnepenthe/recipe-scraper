<?php

use SSNepenthe\RecipeScraper\Client;

class CachedHTTPTestCase extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new Client;
        $this->client->enableGreedyFileCache('.cache', 60 * 60 * 24 * 7);
    }
}
