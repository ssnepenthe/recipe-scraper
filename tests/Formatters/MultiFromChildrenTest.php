<?php

use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;
use SSNepenthe\RecipeScraper\Formatters\MultiFromChildren;

class MultiFromChildrenTest extends CachedHTTPTestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new MultiFromChildren;
    }

    public function test_multiple_items_multiple_locations_again()
    {
        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/'
        );

        $filtered = $crawler->filter('[itemprop="recipeIngredient"]');
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
                '3 medium russet potatoes',
                '4 Tablespoons olive oil, divided',
                '3/4 cup diced yellow onions',
                '5 large eggs',
                '1/4 cup heavy cream',
                '2 large tomatoes, diced',
                '1/2 cup loosely packed parsley leaves',
                '3 Tablespoons red wine vinegar',
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
                '%%TITLE%%Cake%%TITLE%%',
                '1 box Betty Crocker™ SuperMoist™ yellow cake mix',
                '1 cup mashed very ripe bananas (2 medium)',
                '1/2 cup water',
                '1/3 cup vegetable oil',
                '4 eggs',
                '%%TITLE%%Filling%%TITLE%%',
                '1 box (6-serving size) vanilla instant pudding and pie filling mix',
                '3 cups cold milk',
                '1/3 cup creamy peanut butter',
                '%%TITLE%%Topping%%TITLE%%',
                '1 jar (7 oz) marshmallow creme',
                '1 cup butter, softened',
                '2 cups powdered sugar',
                '1/3 cup creamy peanut butter',
                'Sliced bananas',
            ],
            $normalizer->normalize($this->formatter->format($filtered, $config))
        );
    }
}
