<?php

use SSNepenthe\RecipeScraper\Formatters\SingleFromChildren;

class SingleFromChildrenTest extends CachedHTTPTestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new SingleFromChildren;
    }

    public function test_single_item_single_location()
    {
        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/grilled-salmon-with-pesto/'
        );

        $filtered = $crawler->filter('[itemprop="ingredients"]');
        $config = ['locations' => ['_text', 'content']];

        $this->assertEquals(
            ['coconut oil, for grilling'],
            $this->formatter->format($filtered, $config)
        );
    }
}
