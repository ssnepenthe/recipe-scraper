<?php

class RecipeTest extends PHPUnit_Framework_TestCase
{
    protected $recipe;
    protected $props = [
        'cookTime', 'cookingMethod', 'prepTime', 'recipeCategories',
        'recipeCuisines', 'recipeIngredients', 'recipeInstructions',
        'recipeYield', 'totalTime'
    ];

    protected function setUp()
    {
        $this->recipe = new SSNepenthe\RecipeParser\Schema\Recipe;
    }

    public function test_set_up_properties()
    {
        $properties = [
            'cookTime', 'cookingMethod', 'prepTime', 'recipeCategories',
            'recipeCuisines', 'recipeIngredients', 'recipeInstructions',
            'recipeYield', 'totalTime'
        ];

        foreach ($properties as $property) {
            $this->assertContains($property, $this->recipe->getKeys());
        }
    }

    public function test_set_duration_value_on_property()
    {
        $cooktime = new DateInterval('PT10M');

        $this->recipe->setCookTime($cooktime);

        $this->assertSame($cooktime, $this->recipe->cookTime);
    }

    public function test_set_single_group_list_on_property()
    {
        $ingredients = [
            [
                'title' => 'Test Group',
                'data' => [
                    'Test data one',
                    'Test data two',
                    'Test data three',
                ],
            ],
        ];

        $this->recipe->setRecipeIngredients($ingredients);

        $this->assertEquals($ingredients, $this->recipe->recipeIngredients);
    }

    public function test_set_multi_group_list_on_property()
    {
        $instructions = [
            [
                'title' => 'Group One',
                'data' => [ 'G1 D1', 'G1 D2', 'G1 D3'],
            ],
            [
                'title' => 'Group Two',
                'data' => [ 'G2 D1', 'G2 D2', 'G2 D3' ],
            ],
            [
                'title' => 'Group Three',
                'data' => [ 'G3 D1', 'G3 D2', 'G3 D3' ],
            ],
        ];

        $this->recipe->setRecipeInstructions($instructions);

        $this->assertEquals($instructions, $this->recipe->recipeInstructions);
    }

    public function test_throw_exception_when_group_values_arent_arrays()
    {
        $this->expectException(InvalidArgumentException::class);

        $ingredients = [
            'title' => 'Test',
            'data' => [ 'one', 'two', 'three' ],
        ];

        $this->recipe->setRecipeIngredients($ingredients);
    }

    public function test_throw_exception_when_group_data_is_not_set()
    {
        $this->expectException(InvalidArgumentException::class);

        $instructions = [
            [
                'title' => 'Test',
            ]
        ];

        $this->recipe->setRecipeInstructions($instructions);
    }

    public function test_throw_exception_when_group_title_is_not_set()
    {
        $this->expectException(InvalidArgumentException::class);

        $ingredients = [
            [
                'data' => [ 'V1', 'V2', 'V3' ]
            ]
        ];

        $this->recipe->setRecipeIngredients($ingredients);
    }

    public function test_throw_exception_when_group_title_is_not_string()
    {
        $this->expectException(InvalidArgumentException::class);

        $instructions = [
            [
                'title' => 3,
                'data' => [ 'V1', 'V2', 'V3' ]
            ]
        ];

        $this->recipe->setRecipeInstructions($instructions);
    }

    public function test_throw_exception_when_group_data_is_not_array()
    {
        $this->expectException(InvalidArgumentException::class);

        $ingredients = [
            [
                'title' => 'Title',
                'data' => 'Data',
            ]
        ];

        $this->recipe->setRecipeIngredients($ingredients);
    }

    public function test_throw_exception_when_group_data_is_not_array_of_strings()
    {
        $this->expectException(InvalidArgumentException::class);

        $instructions = [
            [
                'title' => 'Title',
                'data' => [ 1, 'V2', 'V3' ]
            ]
        ];

        $this->recipe->setRecipeInstructions($instructions);
    }

    public function test_set_text_list_on_property()
    {
        $categories = [ 'BBQ', 'Summer' ];

        $this->recipe->setRecipeCategories($categories);

        $this->assertEquals($categories, $this->recipe->recipeCategories);
    }

    public function test_throw_exception_when_text_list_contains_non_strings()
    {
        $this->expectException(InvalidArgumentException::class);

        $cuisines = [ 1, '2', '3' ];

        $this->recipe->setRecipeCuisines($cuisines);
    }

    public function test_return_total_time_if_explicitly_set()
    {
        $total = new DateInterval('PT30M');

        $this->recipe->setTotalTime($total);

        $this->assertSame($total, $this->recipe->totalTime);
    }

    public function test_return_calculated_total_time_if_not_explicitly_set()
    {
        $prep = new DateInterval('PT10M');
        $cook = new DateInterval('PT30M');

        $this->recipe->setPrepTime($prep);
        $this->recipe->setCookTime($cook);

        $total = new DateInterval('PT40M');

        $this->assertEquals($total, $this->recipe->totalTime);
    }

    public function test_return_null_total_time_if_prep_and_cook_not_set()
    {
        $this->assertNull($this->recipe->totalTime);
    }
}
