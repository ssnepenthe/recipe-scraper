<?php

use SSNepenthe\RecipeParser\Parsers\DelishCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class DelishComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new DelishCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Nancy Dell\'Aria');
        $recipe->setDescription('Fish can get predictable pretty easily, so liven things up with this creamy chowder featuring cod with corn, bacon and a mix of cubed red potatoes, onions, carrots and celery sautéed in bacon fat.');
        $recipe->setImage('http://del.h-cdn.co/assets/cm/15/10/54f8dc103b330_-_fish-veggie-chowder-lg.jpg');
        $recipe->setName('Fish and Veggie Chowder');
        $recipe->setPrepTime(new DateInterval('PT40M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '4 slice bacon',
                    '2 carrots',
                    '2 stalk celery',
                    '1 large onion',
                    'Kosher salt and pepper',
                    '3 tbsp. all-purpose flour',
                    '3 c. whole milk',
                    '1 lb. red potatoes',
                    '1 1/2 tsp. Old Bay seasoning',
                    '1 c. corn kernels',
                    '3/4 lb. skinless firm white fish (such as, cod, haddock or hake)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Cook the bacon in a large saucepan or Dutch oven over medium heat until crisp, 5 to 6 minutes. Transfer to a paper towel-lined plate. Discard all but 1 Tbsp fat from the pan.',
                    'Add the carrot, celery, onion and 1/2 tsp each salt and pepper to the pan and cook, covered, stirring occasionally, for 5 minutes. Sprinkle the flour over the vegetable mixture and cook, stirring, for 1 minute. Whisk in the milk and 2 cups water and bring to a boil.',
                    'Add the potatoes and Old Bay, reduce heat and simmer until the potatoes are just tender, 12 to 15 minutes. Stir in the corn and fish and simmer until the fish is opaque throughout, 3 to 5 minutes. Break the bacon into pieces and sprinkle over the soup.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT40M'));

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.delish.com/cooking/recipe-ideas/recipes/a33641/fish-veggie-chowder-121971/'
            )
        );
    }
}
