<?php

use SSNepenthe\RecipeParser\Parsers\BettyCrockerCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class BettyCrockerComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new BettyCrockerCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Mmm! There\'s a surprise burst of creamy lemon filling inside these delicious cupcakes.');
        $recipe->setImage('http://images.edge-generalmills.com/6b72b9bf-ff5a-461b-9f39-1a65d97cda26.jpg');
        $recipe->setName('Lemon Burst Cupcakes');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 box Betty Crocker™ SuperMoist™ white cake mix',
                    'Water, vegetable oil and egg whites called for on cake mix box',
                    '1 jar (10 to 12 oz) lemon curd',
                    '1 container (12 oz) Betty Crocker™ Whipped fluffy white frosting',
                    '1/4 cup Betty Crocker™ yellow candy sprinkles',
                    '1/4 cup Betty Crocker™ white candy sprinkles',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Heat oven to 350°F (325°F for dark or nonstick pans). Make, bake and cool cake mix as directed on box for 24 cupcakes.',
                    'By slowly spinning end of round handle of wooden spoon back and forth, make deep, 3/4-inch-wide indentation in center of top of each cupcake, not quite to bottom (wiggle end of spoon in cupcake to make opening large enough).',
                    'Spoon lemon curd into corner of resealable heavy-duty food-storage plastic bag. Cut about 1/4 inch off corner of bag. Gently push cut corner of bag into center of cupcake. Squeeze about 2 teaspoons lemon curd into center of each cupcake for filling, being careful not to split cupcake.',
                    'Frost cupcakes with frosting. To decorate, roll edge of each cupcake in candy sprinkles. Store loosely covered.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('24');
        $recipe->setTotalTime(new DateInterval('PT1H15M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964'
            )
        );
    }
}
