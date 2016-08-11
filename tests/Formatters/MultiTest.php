<?php

use SSNepenthe\RecipeScraper\Formatters\Multi;
use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;

class MultiTest extends CachedHTTPTestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new Multi;
    }

    public function test_multiple_items_single_location()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="ingredients"]');
        $config = ['locations' => ['_text']];

        $this->assertEquals(
            [
                '1/4 cup olive oil',
                '2 cloves garlic, crushed',
                '1/4 cup Italian-seasoned bread crumbs',
                '1/4 cup grated Parmesan cheese',
                '4 skinless, boneless chicken breast halves',
            ],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_multiple_item_multiple_locations()
    {
        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $filtered = $crawler->filter('[itemprop="recipeInstructions"] li');
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
            [
                'Preheat oven to 425 degrees F (220 degrees C).',
                'Heat olive oil and garlic in a small saucepan over low heat until warmed, 1 to 2 minutes. Transfer garlic and oil to a shallow bowl.',
                'Combine bread crumbs and Parmesan cheese in a separate shallow bowl.',
                'Dip chicken breasts in the olive oil-garlic mixture using tongs; transfer to bread crumb mixture and turn to evenly coat. Transfer coated chicken to a shallow baking dish.',
                'Bake in the preheated oven until no longer pink and juices run clear, 30 to 35 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C).',
            ],
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
            [
                '%%TITLE%% Cake %%TITLE%%',
                '1 box Betty Crocker™ SuperMoist™ yellow cake mix',
                '1 cup mashed very ripe bananas (2 medium)',
                '1/2 cup water',
                '1/3 cup vegetable oil',
                '4 eggs',
                '%%TITLE%% Filling %%TITLE%%',
                '1 box (6-serving size) vanilla instant pudding and pie filling mix',
                '3 cups cold milk',
                '1/3 cup creamy peanut butter',
                '%%TITLE%% Topping %%TITLE%%',
                '1 jar (7 oz) marshmallow creme',
                '1 cup butter, softened',
                '2 cups powdered sugar',
                '1/3 cup creamy peanut butter',
                'Sliced bananas',
            ],
            $normalizer->normalize($this->formatter->format($filtered, $config))
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
            [],
            $this->formatter->format($filtered, $config)
        );
    }
}
