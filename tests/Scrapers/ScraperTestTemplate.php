<?php

use SSNepenthe\RecipeScraper\Scrapers\{PARSERCLASS};
use SSNepenthe\RecipeScraper\Schema\Recipe;

class ScraperTestTemplate extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
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

    public function test_scrape_another_standard_recipe()
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

    public function test_scrape_a_recipe_with_ingredient_groups()
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

    public function test_scrape_another_recipe_with_ingredient_groups()
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
