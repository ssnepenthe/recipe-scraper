<?php

use SSNepenthe\RecipeParser\Parsers\FoodAndWineCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class FoodAndWineComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new FoodAndWineCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Melissa Rubel Jacobson');
        $recipe->setDescription('The classic chicken salad can be bolstered with any number of seasonings, from curry powder or mustard to harissa. To turn these two-bite snacks into mini sandwiches, cut the brioche rolls in half, mound the chicken salad, tomato and bacon inside, and secure with a toothpick.');
        $recipe->setImage('http://cdn-image.foodandwine.com/sites/default/files/styles/551x551/public/200809-r-xl-baby-brioches-with-chicken-salad-and-bacon.jpg?itok=N3fZx-He');
        $recipe->setName('Baby Brioches with Chicken Salad and Bacon');
        $recipe->setRecipeCategories([
            'Fall',
            'Winter',
            'Cocktail Party',
            'New Year\'s Eve',
            'Appetizers/starters',
            'Fast',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '4 slices of applewood-smoked bacon',
                    '16 mini brioche rolls (about 2 inches)',
                    '1/3 cup mayonnaise',
                    '1 celery rib, minced',
                    '1/2 small shallot, minced',
                    '2 teaspoons minced flat-leaf parsley, plus 32 large flat-leaf parsley leaves',
                    '1 teaspoon fresh lemon juice',
                    '2 chicken breasts from a rotisserie chicken—skin and bones discarded, chicken cut into 1/3-inch dice',
                    'Kosher salt and freshly ground black pepper',
                    '2 small plum tomatoes, cut into 1/4-inch slices (16 slices)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat the oven to 325°. In a large skillet, cook the bacon over moderate heat until browned and crisp all over, about 5 minutes. Transfer the bacon to paper towels to drain, then cut each slice into 4 pieces.',
                    'Using a paring knife, cut a 1-inch round plug out of the top of each brioche roll. Carefully hollow out the rolls. Set the rolls on a baking sheet and warm them in the oven to refresh them, about 5 minutes.',
                    'In a medium bowl, combine the the mayonnaise, celery, shallot, minced parsley and lemon juice. Stir in the diced chicken and season the salad with salt and pepper.',
                    'Spoon 1 tablespoon of the chicken salad into each brioche roll, garnish with parsley leaves and cover with a tomato slice. Top each roll with 1 teaspoon of chicken salad, garnish with the bacon and serve.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('16 hors d\'oeuvres');
        $recipe->setTotalTime(new DateInterval('PT25M'));
        $recipe->setUrl('http://www.foodandwine.com/recipes/baby-brioches-chicken-salad-and-bacon');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.foodandwine.com/recipes/baby-brioches-with-chicken-salad-and-bacon'
            )
        );
    }
}
