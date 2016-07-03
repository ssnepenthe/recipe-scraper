<?php

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
}
