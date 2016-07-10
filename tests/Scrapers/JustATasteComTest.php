<?php

use SSNepenthe\RecipeScraper\Scrapers\JustATasteCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class JustATasteComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kelly Senyei');
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setDescription('All you need is 30 minutes and a few simple ingredients for a quick and easy Spanish tortilla recipe paired with a refreshing tomato salad.');
        $recipe->setImage('http://www.justataste.com/wp-content/uploads/2016/05/spanish-tortilla-recipe.jpg');
        $recipe->setName('Spanish Tortilla with Tomato Salad');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeCategories([
            '30-Minute Meals',
            'Entrées',
            'Recipes',
            'Salads',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '3 medium russet potatoes',
                    '4 Tablespoons olive oil, divided',
                    '3/4 cup diced yellow onions',
                    '5 large eggs',
                    '1/4 cup heavy cream',
                    '2 large tomatoes, diced',
                    '1/2 cup loosely packed parsley leaves',
                    '3 Tablespoons red wine vinegar',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Peel then cut the potatoes into 1/8-inch-thick slices using a sharp knife or mandoline.',
                    'Add 2 tablespoons olive oil to a large non-stick sauté pan set over low heat. Add the sliced potatoes, diced onions and a pinch of salt. Cover the pan and cook, stirring occasionally, until the potatoes have softened, about 10 minutes. Drain any excess oil from the pan then transfer the mixture to a large bowl.',
                    'In a separate medium bowl, whisk together the eggs and heavy cream with a pinch of salt and black pepper. Pour the egg mixture over the potatoes and fold it carefully to combine without breaking apart the potatoes.',
                    'Add 1 tablespoon olive oil to a non-stick sauté pan set over medium heat. Add the potato mixture to the pan and using a spatula, gently lift the mixture so the uncooked eggs flow underneath. Spread the mixture into an even layer, reduce the heat to low and cook the tortilla, occasionally releasing the edges with a spatula. Once the eggs are mostly set, place a plate atop the pan then invert the pan to flip the tortilla onto the plate. Return the tortilla to the pan (uncooked side down) and continue cooking until the eggs are fully set.',
                    'Slide the cooked tortilla onto a serving plate.',
                    'In a small bowl, combine the diced tomatoes and parsley leaves. Toss the salad with the remaining 1 tablespoon olive oil, red wine vinegar, and a pinch of salt and pepper. Pile the salad atop the tortilla, slice and serve.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/'
        );
        $scraper = new JustATasteCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
