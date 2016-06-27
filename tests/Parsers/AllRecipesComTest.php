<?php

use SSNepenthe\RecipeParser\Parsers\AllRecipesCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class AllRecipesComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new AllRecipesCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Carol');
        $recipe->setCookTime(new \DateInterval('PT35M'));
        $recipe->setDescription('This easy, tasty dish is perfect for a weeknight dinner.');
        $recipe->setImage('http://brightcove.vo.llnwd.net/d21/unsecured/media/1033249144001/1033249144001_1969620794001_ari-origin05-arc-179-1352942793309.jpg?pubId=1033249144001');
        $recipe->setName('Garlic Chicken');
        $recipe->setPrepTime(new \DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/4 cup olive oil',
                    '2 cloves garlic, crushed',
                    '1/4 cup Italian-seasoned bread crumbs',
                    '1/4 cup grated Parmesan cheese',
                    '4 skinless, boneless chicken breast halves',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat oven to 425 degrees F (220 degrees C).',
                    'Heat olive oil and garlic in a small saucepan over low heat until warmed, 1 to 2 minutes. Transfer garlic and oil to a shallow bowl.',
                    'Combine bread crumbs and Parmesan cheese in a separate shallow bowl.',
                    'Dip chicken breasts in the olive oil-garlic mixture using tongs; transfer to bread crumb mixture and turn to evenly coat. Transfer coated chicken to a shallow baking dish.',
                    'Bake in the preheated oven until no longer pink and juices run clear, 30 to 35 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C).',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new \DateInterval('PT55M'));
        $recipe->setUrl('http://allrecipes.com/recipe/8652/garlic-chicken/');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://allrecipes.com/recipe/8652/garlic-chicken/'
            )
        );
    }
}
