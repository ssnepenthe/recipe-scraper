<?php

use SSNepenthe\RecipeScraper\Formatters\Single;

class SingleTest extends CachedHTTPTestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new Single;
    }

    public function test_single_item_single_location()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="recipeYield"]');
        $config = ['locations' => ['content']];

        $this->assertEquals(
            ['4'],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_single_item_multiple_locations()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="prepTime"]');
        $config = [
            'locations' => [
                'datetime',
                'content',
                'href',
                'data-src',
                'src',
                '_text',
            ],
        ];

        $this->assertEquals(
            ['PT20M'],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_multiple_items_single_location()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="recipeInstructions"] li');
        $config = ['locations' => ['_text']];

        $this->assertEquals(
            ['Preheat oven to 425 degrees F (220 degrees C).'],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_multiple_items_multiple_locations()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="ingredients"]');
        $config = [
            'locations' => [
                'datetime',
                'content',
                'href',
                'data-src',
                'src',
                '_text',
            ],
        ];

        $this->assertEquals(
            ['1/4 cup olive oil'],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_no_data_in_locations()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="cookTime"]');
        $config = ['locations' => ['data-id', 'data-src']];

        $this->assertEquals(
            [''],
            $this->formatter->format($filtered, $config)
        );
    }
}
