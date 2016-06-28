<?php

use SSNepenthe\RecipeParser\Schema\Recipe;
use SSNepenthe\RecipeParser\Parsers\TablespoonCom;

class TablespoonComTest extends ParserTestCase
{
	public function setUp()
    {
        $this->parser = new TablespoonCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Daring Gourmet');
        $recipe->setDescription('A BLT with avocado AND a drizzle of sweet-tangy balsamic reduction? Yes, please!');
        $recipe->setImage('http://images.edge-generalmills.com/119bc525-b6c4-4dfb-ac8f-08e55ab8a1ba.jpg');
        $recipe->setName('Bacon-Avocado-Lettuce-Tomato Snack Sandwich');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/3 cup good quality aged balsamic vinegar',
                    '4 slices bread, toasted or grilled',
                    'Mayonnaise',
                    '4 leaves lettuce',
                    '8 thick cut slices bacon, cooked',
                    '8 slices tomato',
                    '8 slices avocado',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'To make the balsamic reduction, place the balsamic vinegar in a very small saucepan and bring it to a boil. Reduce the heat to medium-low and simmer uncovered for about 15 minutes or until it is thickened and lightly coats a spoon.',
                    'To assemble the sandwiches, spread some mayonnaise on each slice of toasted bread. Next layer with lettuce, 2 slices of bacon, 2 slices of tomato and 2 slices of avocado. Drizzle with the balsamic vinegar reduction and serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT15M'));
        $recipe->setUrl('http://www.tablespoon.com/recipes/bacon-avocado-lettuce-tomato-snack-sandwich/780d10c2-77e0-441b-9f75-1bb23e2081e0');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.tablespoon.com/recipes/bacon-avocado-lettuce-tomato-snack-sandwich/780d10c2-77e0-441b-9f75-1bb23e2081e0'
            )
        );
    }
}
