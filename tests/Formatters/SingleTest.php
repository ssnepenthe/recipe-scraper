<?php

use SSNepenthe\RecipeScraper\Formatters\Single;
use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;

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

    public function test_mark_item_as_title()
    {
        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/banana-peanut-butter-and-marshmallow-poke-cake/5e2b9f28-7d7e-4ce2-af66-6a958d47046c'
        );

        $filtered = $crawler->filter('.recipePartIngredientGroup h2, .recipePartIngredientGroup dl');
        $config = ['locations' => ['_text']];

        // There will be some wacky spacing so we need to normalize as well.
        $normalizer = new NormalizerStack;
        $normalizer->push(new EndOfLine);
        $normalizer->push(new SingleLine);
        $normalizer->push(new Space);

        $this->assertEquals(
            ['%%TITLE%% Cake %%TITLE%%'],
            $normalizer->normalize($this->formatter->format($filtered, $config))
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
