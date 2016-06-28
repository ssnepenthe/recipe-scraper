<?php

use SSNepenthe\RecipeParser\Parsers\{PARSERCLASS};
use SSNepenthe\RecipeParser\Schema\Recipe;

class ParserTestTemplate extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new {PARSERCLASS};
    }

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

        $this->assertEquals(
            $recipe,
            $this->recipe(
                '{URL}'
            )
        );
    }
}
