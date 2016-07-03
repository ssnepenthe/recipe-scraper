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
            ['Preheat oven to 425 degrees F (220 degrees C). Heat olive oil and garlic in a small saucepan over low heat until warmed, 1 to 2 minutes. Transfer garlic and oil to a shallow bowl. Combine bread crumbs and Parmesan cheese in a separate shallow bowl. Dip chicken breasts in the olive oil-garlic mixture using tongs; transfer to bread crumb mixture and turn to evenly coat. Transfer coated chicken to a shallow baking dish. Bake in the preheated oven until no longer pink and juices run clear, 30 to 35 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C).'],
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
            ['1/4 cup olive oil 2 cloves garlic, crushed 1/4 cup Italian-seasoned bread crumbs 1/4 cup grated Parmesan cheese 4 skinless, boneless chicken breast halves'],
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
