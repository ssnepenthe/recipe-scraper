<?php

use SSNepenthe\RecipeScraper\Scrapers\FoodAndWineCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class FoodAndWineComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
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
                    'Preheat the oven to 325 °. In a large skillet, cook the bacon over moderate heat until browned and crisp all over, about 5 minutes. Transfer the bacon to paper towels to drain, then cut each slice into 4 pieces.',
                    'Using a paring knife, cut a 1-inch round plug out of the top of each brioche roll. Carefully hollow out the rolls. Set the rolls on a baking sheet and warm them in the oven to refresh them, about 5 minutes.',
                    'In a medium bowl, combine the the mayonnaise, celery, shallot, minced parsley and lemon juice. Stir in the diced chicken and season the salad with salt and pepper.',
                    'Spoon 1 tablespoon of the chicken salad into each brioche roll, garnish with parsley leaves and cover with a tomato slice. Top each roll with 1 teaspoon of chicken salad, garnish with the bacon and serve.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('16 hors d\'oeuvres');
        $recipe->setTotalTime(new DateInterval('PT25M'));
        $recipe->setUrl('http://www.foodandwine.com/recipes/baby-brioches-chicken-salad-and-bacon');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodandwine.com/recipes/baby-brioches-with-chicken-salad-and-bacon'
        );
        $scraper = new FoodAndWineCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kay Chun');
        $recipe->setDescription('Luscious, rich and lemony hollandaise gets completely re-imagined here in a light, supremely creamy puree of avocado, lemon juice and olive oil.');
        $recipe->setImage('http://cdn-image.foodandwine.com/sites/default/files/styles/551x551/public/201402-xl-avocado-hollandaise.jpg?itok=BA_I8MaS');
        $recipe->setName('Avocado Hollandaise');
        $recipe->setRecipeCategories([
            'Easter',
            'Mother\'s Day',
            'Sauces & Condiments',
            'Fast',
            'Gluten-Free',
            'Healthy',
            'Vegetarian',
            'Breakfast',
            'Brunch',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/2 very ripe medium Hass avocado, peeled and chopped',
                    '2 teaspoons fresh lemon juice',
                    '2 tablespoons extra-virgin olive oil',
                    'Kosher salt',
                    'Freshly ground pepper',
                    'Poached eggs, for serving',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a blender, combine the avocado and lemon juice with 1/3 cup of hot water. Puree until smooth and light in texture, about 2 minutes, scraping down the side of the bowl occasionally. With the machine on, drizzle in the olive oil and puree until combined. Season with salt and pepper. Serve the hollandaise over poached eggs.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT10M'));
        $recipe->setUrl('http://www.foodandwine.com/recipes/avocado-hollandaise');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodandwine.com/recipes/avocado-hollandaise'
        );
        $scraper = new FoodAndWineCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Grace Parisi');
        $recipe->setDescription('To vary the filling here, use 4 pounds of stone fruit (peaches, nectarines and apricots) cut into large wedges; or 4 pounds of plums, cut into 1-inch cubes; or 6 pints of blueberries plus 2 tablespoons of fresh lemon juice.');
        $recipe->setImage('http://cdn-image.foodandwine.com/sites/default/files/styles/551x551/public/200808xl-mixed-berry-spoon-cake_0.jpg?itok=3AgcG0ce');
        $recipe->setName('Mixed-Berry Spoon Cake');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeCategories([
            'Summer',
            'Test Kitchen',
            'Baking',
            'Barbecue/Cookout',
            'Father\'s Day',
            'Mother\'s Day',
            'Cakes & Cupcakes',
            'Casseroles & Gratins',
            'Desserts',
            'Make Ahead',
            'Staff Favorites',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'Filling',
                'data'  => [
                    '4 pints strawberries (2 pounds), hulled and quartered',
                    '2 pints blackberries (12 ounces)',
                    '2 pints raspberries (12 ounces)',
                    '3/4 cup sugar',
                    '2 tablespoons cornstarch',
                ],
            ],
            [
                'title' => 'Batter',
                'data'  => [
                    '1 1/2 cups all-purpose flour',
                    '1 cup sugar',
                    '2 teaspoons finely grated lemon zest',
                    '1 1/2 teaspoons baking powder',
                    '1 teaspoon kosher salt',
                    '2 eggs',
                    '1/2 cup milk',
                    '1 teaspoon pure vanilla extract',
                    '1 1/2 sticks unsalted butter, melted',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a bowl, toss the berries with the sugar and cornstarch and let stand for 10 minutes.',
                    'Preheat the oven to 375 °. In a medium bowl, whisk the flour with the sugar, lemon zest, baking powder and salt. In a small bowl, whisk the eggs with the milk and vanilla. Whisk the liquid into the dry ingredients until evenly moistened, then whisk in the melted butter until smooth.',
                    'Spread the filling in a 9-by-13-inch baking dish. Spoon the batter on top, leaving small gaps. Bake in the center of the oven for 1 hour, until the fruit is bubbling and a toothpick inserted into the topping comes out clean. Let cool for 1 hour before serving.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('8 to 10');
        $recipe->setTotalTime(new DateInterval('PT2H20M'));
        $recipe->setUrl('http://www.foodandwine.com/recipes/mixed-berry-spoon-cake');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodandwine.com/recipes/mixed-berry-spoon-cake'
        );
        $scraper = new FoodAndWineCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Leetal Arazi');
        $recipe->setDescription('These luscious doughnuts are crispy on the outside and very fluffy and airy on the inside. They\'re usually served dipped in sugar or honey, but Leetal and Ron Arazi love to serve them with a saffron and cardamom syrup.');
        $recipe->setImage('http://cdn-image.foodandwine.com/sites/default/files/styles/551x551/public/201412-xl-sfinj-moroccan-doughnuts.jpg?itok=ClS4JKuU');
        $recipe->setName('Sfinj (Moroccan Doughnuts)');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeCategories([
            'Winter',
            'Hannukah',
            'Holiday Open House',
            'Moroccan',
            'Desserts',
            'Vegetarian',
            'Breakfast',
            'Brunch',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'Sugar Syrup',
                'data'  => [
                    '1 cup water',
                    '1 cup sugar',
                    '5 cardamom pods',
                    'Pinch of saffron threads',
                ],
            ],
            [
                'title' => 'Doughnuts',
                'data'  => [
                    '8 cups unbleached all-purpose flour',
                    '2 tablespoons yeast',
                    '2 teaspoons baking powder',
                    '2 teaspoons salt',
                    '1 teaspoon sugar',
                    '3 to 4 cups water',
                    'Canola oil, for frying',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Make the Sugar Syrup In a medium saucepan, combine all of the ingredients and bring to a boil. Reduce the heat and simmer until the syrup is the consistency of honey. (To test, place a few small plates in the freezer and drizzle a bit of the syrup on them throughout the cooking process.) Remove from the heat and let cool.',
                    'Make the Doughnuts In a large bowl, combine all of the dry ingredients. Add 3 1/2 cups of water and mix thoroughly; the dough should be loose and sticky and doesn’t need to hold its shape. Adjust the consistency if needed with the rest of the water. Cover the dough with cling plastic wrap and let rest for 30 minutes.',
                    'Make the Doughnuts In the bowl, using your hands, fold the dough over onto itself few times. Cover and let rise for 30 minutes, or until it doubles in volume. In a deep pan, heat 3 inches high of canola oil.',
                    'Make the Doughnuts Wet your hands and cut a piece of dough the size of 2 golf balls. With 2 fingers quickly make a hole in the center and stretch it a little to form a ring shape. Repeat to form the remaining doughnuts.',
                    'Make the Doughnuts Immediately and gently put the doughnuts in the oil and fry over moderate heat until golden on both sides. Drain the doughnuts on paper towels.',
                    'Make the Doughnuts Serve the sfinj immediately and let your guests drizzle them with the sugar syrup.',
                ],
            ]
        ]);
        $recipe->setTotalTime(new DateInterval('PT1H30M'));
        $recipe->setUrl('http://www.foodandwine.com/recipes/sfinj-moroccan-doughnuts');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodandwine.com/recipes/sfinj-moroccan-doughnuts'
        );
        $scraper = new FoodAndWineCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
