<?php

use SSNepenthe\RecipeParser\Schema\Recipe;
use SSNepenthe\RecipeParser\Parsers\PaulaDeenCom;

class PaulaDeenComTest extends ParserTestCase
{
	public function setUp()
    {
        $this->parser = new PaulaDeenCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setDescription('A hearty and easy chicken chili.');
        $recipe->setImage('http://static.pauladeen.com/media/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/c/h/chicken_chili_stew_1.jpg');
        $recipe->setName('Chicken Chili Stew');
        $recipe->setPrepTime(new DateInterval('PT5M'));
        $recipe->setRecipeIngredients([
        	[
                'title' => '',
        		'data'  => [
				    '1 tablespoon canola oil',
				    '1 medium onion, chopped',
				    '1 yellow bell pepper, chopped',
				    '3 cloves garlic, chopped',
				    '1 small jalapeño, seeds removed and chopped',
				    '1 tablespoon chili powder',
				    '4 cups chicken broth',
				    '1 medium sweet potato, peeled and cubed',
				    '2 cups salsa verde, store bought',
				    '12 oz leftover roasted chicken, skinned and shredded into large pieces',
				    '1 (15 oz) can pinto beans, drained and rinsed',
				    '1/2 cup fresh cilantro, chopped and packed',
				    '1 avocado, diced, for garnish',
				    'sour cream, for garnish',
        		],
        	]
        ]);
        $recipe->setRecipeInstructions([
        	[
                'title' => '',
        		'data' =>  [
					'Heat oil in a large pot over medium high heat. Add the onion, bell pepper, garlic, and jalapeño and sauté until soft, about 4 minutes. Add chili powder and season with salt.',
					'Stir in the chicken broth, sweet potato and salsa verde, and bring to a boil. Reduce heat and simmer, stirring occasionally, until the sweet potato is just tender, about 10-12 minutes.',
					'Stir in the shredded chicken and beans. Reduce heat to moderately low and simmer, covered, 10 minutes. Stir in cilantro at the end of cooking. Ladle into soup bowls and top with some diced avocado and a dollop of sour cream.',
					'Paula\'s Note: You can find Salsa Verde in the Latin Foods section of your grocery store.',
        		],
        	]
        ]);
        $recipe->setTotalTime(new DateInterval('PT30M'));
        $recipe->setUrl('http://www.pauladeen.com/chicken-chili-stew/');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.pauladeen.com/chicken-chili-stew/'
            )
        );
    }
}
