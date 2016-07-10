<?php

use SSNepenthe\RecipeScraper\Scrapers\{PARSERCLASS};
use SSNepenthe\RecipeScraper\Schema\Recipe;

class ParserTestTemplate extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('');
        $recipe->setCookTime(new DateInterval(''));
        $recipe->setCookingMethod('');
        $recipe->setDescription('');
        $recipe->setImage('');
        $recipe->setName('');
        $recipe->setPrepTime(new DateInterval(''));
        $recipe->setPublisher('');
        $recipe->setRecipeCategories([]);
        $recipe->setRecipeCuisines([]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [],
            ],
        ]);
        $recipe->setRecipeYield('');
        $recipe->setTotalTime(new DateInterval(''));
        $recipe->setUrl('');

        $crawler = $this->client->request(
            'GET',
            '{URL}'
        );
        $scraper = new {PARSERCLASS}($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
