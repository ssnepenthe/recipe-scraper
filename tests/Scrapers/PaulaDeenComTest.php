<?php

use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Scrapers\PaulaDeenCom;

class PaulaDeenComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
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

        $crawler = $this->client->request(
            'GET',
            'http://www.pauladeen.com/chicken-chili-stew/'
        );
        $scraper = new PaulaDeenCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setDescription('Nana\'s Blueberry Muffins by Paula Deen is a classic breakfast pastry that\'s simply delicious.');
        $recipe->setImage('http://static.pauladeen.com/media/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/n/a/nanas-blueberry-muffins_1.jpg');
        $recipe->setName('Nana\'s Blueberry Muffins');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/2 cup butter, room temperature',
                    '1 1/4 cups sugar, plus 2 teaspoons, divided',
                    '2 eggs',
                    '2 cups all-purpose flour',
                    '2 teaspoons baking powder',
                    '1/2 teaspoon salt',
                    '1/2 cup milk',
                    '2 1/2 cups fresh blueberries',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' =>  [
                    'Preheat oven to 350 °.',
                    'Line a 12 cup muffin tin with paper liners and set aside.',
                    'In a large mixing bowl, beat butter and 1 1/4 cups sugar until fluffy and pale in color.',
                    'Add in eggs one at a time, beating well after each addition.',
                    'In a separate mixing bowl, sift together flour, baking powder and salt.',
                    'Add the flour mixture to the butter mixture alternating with the milk until well incorporated and being careful not to over mix.',
                    'Gently fold in the fresh blueberries.',
                    'Scoop batter into the paper lined muffin tin and sprinkle the tops with the remaining 2 teaspoons sugar.',
                    'Bake for 25-30 minutes or until puffy and golden brown.',
                ],
            ]
        ]);
        $recipe->setTotalTime(new DateInterval('PT40M'));
        $recipe->setUrl('http://www.pauladeen.com/nanas-blueberry-muffins/');

        $crawler = $this->client->request(
            'GET',
            'http://www.pauladeen.com/recipes-category/breakfast/nanas-blueberry-muffins'
        );
        $scraper = new PaulaDeenCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_big_steps()
    {
        $recipe = new Recipe;
        $recipe->setDescription('A double-chocolate shake becomes even more decadent with the addition of a brownie!');
        $recipe->setImage('http://static.pauladeen.com/media/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/s/0/s01ep08022_onek_chocolatebrownieshake_i_e_eng_1.jpg');
        $recipe->setName('Chocolate Brownie Shake');
        $recipe->setPrepTime(new DateInterval('PT4M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/2 cup chocolate syrup, plus extra for top',
                    '3 cups chocolate ice cream',
                    '1 (2 inch) square brownie',
                    '1 1/2 cups whole milk',
                    '1 can whipped cream, or homemade, for topping',
                    '1 maraschino cherry, long-stemmed, for topping',
                    'chocolate, shaved, for topping',
                    'mint, for topping',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' =>  [
                    'Squeeze the chocolate sauce around the inside of a milkshake glass.',
                    'Add the chocolate ice cream, brownie (reserving some crumbs) and milk to a blender and blend until smooth.',
                    'Pipe the whipped cream on the shake using a pastry bag fitted with a star tip and drizzle with some extra chocolate sauce, brownie crumbs, shaved chocolate, fresh mint and a cherry.',
                ],
            ]
        ]);
        $recipe->setTotalTime(new DateInterval('PT4M'));
        $recipe->setUrl('http://www.pauladeen.com/chocolate-brownie-shake/');

        $crawler = $this->client->request(
            'GET',
            'http://www.pauladeen.com/recipes-category/desserts/chocolate-brownie-shake'
        );
        $scraper = new PaulaDeenCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setImage('http://static.pauladeen.com/media/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/c/r/crabquicherecipe_1.jpg');
        $recipe->setName('Crab & Asparagus Quiche Cupcakes');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 cup unsalted butter, cold',
                    '1 cup all-purpose flour, plus 4 teaspoons',
                    '3 tablespoons cold water',
                    '1/4 teaspoon cracked black pepper',
                    '1/8 teaspoon salt, plus 1/4 teaspoon',
                    '1/2 lb asparagus',
                    '1 tablespoon olive oil',
                    '1/3 cup shredded gruyere',
                    '3 large eggs',
                    '1 cup heavy whipping cream',
                    '1 pinch dry mustard',
                    '1/2 cup crabmeat, cooked',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'For The Crust',
                'data' =>  [
                    'Preheat oven to 350 F.',
                    'Cut cold butter into 1/4 inch cubes.',
                    'Add flour and butter to a small mixing bowl. Use your hands to combine until the mixture resembles small pebbles.',
                    'Add water a tablespoon at a time. Continue mixing with your hands until the mixture sticks together when you squeeze it, being careful to not over mix. The batter should not become a solid ball.',
                    'Line a cupcake tin with 12 liners.',
                    'Divide batter evenly between the liners. Press batter into the bottom of each liner and push it about halfway up the sides.',
                    'Bake for 15 minutes.',
                ],
            ],
            [
                'title' => 'For The Roasted Asparagus',
                'data' =>  [
                    'Break the tough ends off of each spear and discard.',
                    'Cut the asparagus into 3/4 inch pieces.',
                    'In a small bowl, toss asparagus with olive oil and salt.',
                    'Spread asparagus on a baking sheet and broil at 450 F for 15 minutes.',
                ],
            ],
            [
                'title' => 'For The Quiche',
                'data' =>  [
                    'Preheat oven to 350 F.',
                    'In a small bowl, mix the gruyere and flour. Set aside.',
                    'In a medium-sized bowl, whip eggs with heavy whipping cream and mustard until fully integrated.',
                    'Sprinkle gruyere evenly over pre-baked pie crusts.',
                    'Spoon crab meat on top of the gruyere, evenly distributing it between the cupcakes.',
                    'Pour egg mixture over crab meat, filling the cupcake liners about 3/4 full.',
                    'Arrange asparagus pieces on top of the egg mixture.',
                    'Bake for 30 minutes.',
                    'Remove from cupcake tins and set on paper towels to dry any moisture off of the bottoms of the liners.',
                    'Serve warm.',
                ],
            ],
        ]);
        $recipe->setUrl('http://www.pauladeen.com/crab-asparagus-quiche-cupcakes/');

        $crawler = $this->client->request(
            'GET',
            'http://www.pauladeen.com/recipes-category/breakfast/crab-asparagus-quiche-cupcakes/'
        );
        $scraper = new PaulaDeenCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT50M'));
        $recipe->setDescription('A sweet and delicious baked french toast casserole with a praline topping.');
        $recipe->setImage('http://static.pauladeen.com/media/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/b/a/baked_french_toast_casserole_1.jpg');
        $recipe->setName('Baked French Toast Casserole');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    'dash salt',
                    '1 teaspoon ground nutmeg, divided',
                    '1 teaspoon ground cinnamon, divided',
                    '1 tablespoon vanilla extract',
                    '2 tablespoons sugar',
                    '1 cup milk',
                    '8 large eggs',
                    '2 cups half and half',
                    '1 loaf French bread, (13 to 16 oz)',
                    '1/2 lb butter, plus more for pan',
                    '1 cup light brown sugar, packed',
                    '1 cup chopped pecans',
                    '2 tablespoons light corn syrup',
                    '1 cup raspberry preserves',
                    '3 tablespoons water',
                    '2 tablespoons raspberry liqueur',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' =>  [
                    'Slice French bread into 20 slices, 1-inch thick each. (Use any extra bread for garlic toast or bread crumbs). Arrange slices in a generously buttered 9X13 casserole dish in 2 rows, overlapping the slices.',
                    'In a large bowl, combine the eggs, half and half, milk, sugar, vanilla, 1/2 teaspoon cinnamon, 1/2 teaspoon nutmeg and salt and beat with a rotary beater or whisk until blended but not too bubbly. Pour mixture over the bread slices, making sure all are covered evenly with the milk-egg mixture. Spoon some of the mixture in between the slices. Cover with foil and refrigerate overnight.',
                    'The next day, preheat oven to 350 °. Spread Praline Topping evenly over the bread and bake for 45 minutes, until puffed and lightly golden. Serve with Raspberry Syrup.',
                ],
            ],
            [
                'title' => 'Praline Topping',
                'data' =>  [
                    'Combine butter, brown sugar, pecans, light corn syrup, 1/2 teaspoon cinnamon and 1/2 teaspoon nutmeg in a medium bowl and blend well. Spread over bread as directed above.',
                ],
            ],
            [
                'title' => 'Raspberry Syrup',
                'data' =>  [
                    'Combine raspberry preserves, water and liqueur in a small saucepan and place over medium heat. Stir until warm and thinned out like syrup.',
                ],
            ],
        ]);
        $recipe->setTotalTime(new DateInterval('PT60M'));
        $recipe->setUrl('http://www.pauladeen.com/baked-french-toast-casserole/');

        $crawler = $this->client->request(
            'GET',
            'http://www.pauladeen.com/baked-french-toast-casserole/'
        );
        $scraper = new PaulaDeenCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
