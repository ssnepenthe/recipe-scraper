<?php

use SSNepenthe\RecipeParser\Parsers\SpryLivingCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class SpryLivingComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new SpryLivingCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Our Cookbook Collection');
        $recipe->setDescription('Wild salmon, dressed in fresh pesto sauce and served alongside vibrant yellow squash—the ultimate summertime grill menu.');
        $recipe->setImage('http://i2.wp.com/spryliving.com/wp-content/uploads/2016/05/unnamed.jpg?resize=670%2C405');
        $recipe->setName('Grilled Salmon with Garlic-Kale Pesto and Summer Squash');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    'coconut oil, for grilling',
                    '2cups garlic scapes',
                    '2cups packed kale leaves',
                    '1/2cup olive oil',
                    '1/2cup grated Parmesan or pecorino Romano cheese',
                    '1/4teaspoon salt',
                    '1/8teaspoon freshly ground black pepper',
                    '1pound (4 filets) wild salmon, skin intact',
                    '1pound yellow squash, sliced into 1/4-inch strips',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Oil a grill with coconut oil and preheat the grill over high heat.',
                    'Put the garlic scapes, kale, olive oil, cheese, salt, and pepper in a food processor or blender and process until finely chopped. Divide the pesto in half and reserve one-half for another use.',
                    'Place the salmon on the grill, flesh side down, and grill 3 to 4 minutes. Turn the salmon, and place the squash slices on the grill. Brush the pesto over the salmon and the squash.Grill the squash, turning it occasionally, for 4 to 5 minutes until cooked through. Grill the salmon 4 to 5 minutes until the skin crisps but the center is still medium. Transfer to a plate and serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://spryliving.com/recipes/grilled-salmon-with-pesto/');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://spryliving.com/recipes/grilled-salmon-with-pesto/'
            )
        );
    }
}
