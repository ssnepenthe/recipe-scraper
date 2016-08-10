<?php

use SSNepenthe\RecipeScraper\Scrapers\AllRecipesCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class AllRecipesComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Carol');
        $recipe->setCookTime(new \DateInterval('PT35M'));
        $recipe->setDescription('This easy, tasty dish is perfect for a weeknight dinner.');
        $recipe->setImage('http://images.media-allrecipes.com/userphotos/250x250/394412.jpg');
        $recipe->setName('Garlic Chicken');
        $recipe->setPrepTime(new \DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/4 cup olive oil',
                    '2 cloves garlic, crushed',
                    '1/4 cup Italian-seasoned bread crumbs',
                    '1/4 cup grated Parmesan cheese',
                    '4 skinless, boneless chicken breast halves',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat oven to 425 degrees F (220 degrees C).',
                    'Heat olive oil and garlic in a small saucepan over low heat until warmed, 1 to 2 minutes. Transfer garlic and oil to a shallow bowl.',
                    'Combine bread crumbs and Parmesan cheese in a separate shallow bowl.',
                    'Dip chicken breasts in the olive oil-garlic mixture using tongs; transfer to bread crumb mixture and turn to evenly coat. Transfer coated chicken to a shallow baking dish.',
                    'Bake in the preheated oven until no longer pink and juices run clear, 30 to 35 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C).',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new \DateInterval('PT55M'));
        $recipe->setUrl('http://allrecipes.com/recipe/8652/garlic-chicken/');

        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );
        $scraper = new AllRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('luaucow');
        $recipe->setCookTime(new \DateInterval('PT30M'));
        $recipe->setDescription('A tasty layered casserole of chicken and vegetables ready in under an hour.');
        $recipe->setImage('http://images.media-allrecipes.com/userphotos/720x405/1118325.jpg');
        $recipe->setName('Baked Chicken and Zucchini');
        $recipe->setPrepTime(new \DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 egg',
                    '1 tablespoon water',
                    '1/2 teaspoon salt',
                    '1/8 teaspoon ground black pepper',
                    '1 cup dry bread crumbs',
                    '2 tablespoons olive oil',
                    '4 skinless, boneless chicken breast halves',
                    '1 tablespoon minced garlic',
                    '2 tablespoons olive oil',
                    '5 zucchinis, sliced',
                    '4 tomatoes, sliced',
                    '2/3 cup shredded mozzarella cheese',
                    '2 teaspoons chopped fresh basil',
                    '1/3 cup shredded mozzarella cheese',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat oven to 400 degrees F (205 degrees C). Lightly grease a 9x13-inch baking dish.',
                    'Beat egg, water, salt, and pepper in a shallow bowl. Set 2 tablespoons bread crumbs aside; pour remaining bread crumbs into a large resealable plastic bag. Dip chicken in egg mixture, then place in bag and shake to coat.',
                    'Heat 2 tablespoons olive oil in a large skillet over medium heat. Cook chicken in skillet until browned, 2 to 3 minutes per side. Remove chicken from pan. Add remaining 2 tablespoons oil to skillet; cook and stir zucchini and garlic over medium heat until zucchini is slightly tender, about 2 minutes. Transfer to prepared baking dish.',
                    'Sprinkle 2 tablespoons reserved bread crumbs over zucchini. Top with tomato slices, 2/3 cup mozzarella cheese, and basil. Place chicken on top of zucchini layer. Cover baking dish with aluminum foil.',
                    'Bake in preheated oven until chicken is no longer pink in the center and juices run clear, about 25 minutes. An instant-read thermometer inserted into the center should read at least 165 degrees F (74 degrees C). Uncover and sprinkle with remaining mozzarella cheese. Bake until cheese is melted, about 5 minutes.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new \DateInterval('PT50M'));
        $recipe->setUrl('http://allrecipes.com/recipe/222585/baked-chicken-and-zucchini/');

        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/222585/baked-chicken-and-zucchini/'
        );
        $scraper = new AllRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Nestle® Beneful®');
        $recipe->setCookTime(new DateInterval('PT20M'));
        $recipe->setDescription('Apple slices, cider, thyme and mustard bring incredible, rich flavors to this easy chicken dinner. Wild or brown rice makes a perfect side dish.');
        $recipe->setImage('http://images.media-allrecipes.com/userphotos/720x405/2731461.jpg');
        $recipe->setName('Apple Cider Chicken with Wild Rice');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Chicken',
                'data'  => [
                    '3 skinless, boneless chicken breast halves, cut in half lengthwise to make thin cutlets',
                    'salt and ground black pepper to taste',
                    '1 tablespoon canola oil or other neutral-flavor cooking oil',
                    '1/4 cup shallots, minced',
                    '1 tablespoon apple cider vinegar',
                    '2 cups sweet apple cider',
                    '1 tart apple, such as Granny Smith - peeled, cored and thinly sliced',
                    '1 sweet apple, such as Gala or Fuji - peeled, cored and thinly sliced',
                    '1 cup chicken broth',
                    '3 teaspoons cornstarch',
                    '2 tablespoons fresh thyme leaves',
                    '1 teaspoon Dijon mustard',
                    'salt and pepper to taste',
                ],
            ],
            [
                'title' => 'Sides',
                'data'  => [
                    '3 cups cooked wild rice or brown rice, or combination of the two',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Season chicken cutlets with salt and pepper.',
                    'Get a skillet very hot. Once it is hot, add oil to it and brown the chicken on both sides. Cook for about 5 minutes on each side, until it\'s a nice, golden color. Remove from the pan and set aside on a plate. It\'s okay that it\'s undercooked, it will finished cooking in the sauce.',
                    'Over high heat, brown the shallots.',
                    'Add cider vinegar and scrape the bottom of the pan, getting all the shallots and any leftover browned chicken bits.',
                    'Before the vinegar evaporates, add the cider and the apple slices. Let this reduce on high for about 3 minutes. The apples and shallots will get very tender.',
                    'While they reduce, mix the chicken broth and the cornstarch until there are no lumps left, then slowly add it to the bubbling cider and apples, stirring all the time while the sauce thickens.',
                    'Mix in thyme, mustard, salt and pepper.',
                    'Return the chicken and its juices back into the sauce, turn down to medium-low and summer for at least 10 minutes, or until the chicken is cooked all the way through. Serve with hot cooked rice.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT35M'));
        $recipe->setUrl('http://allrecipes.com/recipe/245148/apple-cider-chicken-with-wild-rice/');

        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/245148/apple-cider-chicken-with-wild-rice/'
        );
        $scraper = new AllRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Taste of Home\'s Fast Family Favorites');
        $recipe->setDescription('If you like pumpkin, you\'ll love these moist muffins. With an appealing streusel topping and tender apple bits throughout, they make a great accompaniment to a meal or a handy breakfast on the run.');
        $recipe->setImage('http://images.media-allrecipes.com/userphotos/250x250/742085.jpg');
        $recipe->setName('Apple Pumpkin Muffins');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 1/2 cups all-purpose flour',
                    '2 cups sugar',
                    '1 tablespoon pumpkin pie spice',
                    '1 teaspoon baking soda',
                    '1/2 teaspoon salt',
                    '2 eggs',
                    '1 cup canned or cooked pumpkin',
                    '1/2 cup vegetable oil',
                    '2 cups finely chopped peeled apples',
                ],
            ],
            [
                'title' => 'Streusel',
                'data'  => [
                    '1/4 cup sugar',
                    '2 tablespoons all-purpose flour',
                    '1/2 teaspoon ground cinnamon',
                    '4 teaspoons cold butter or margarine',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a bowl, combine the first five ingredients. In another bowl, combine the eggs, pumpkin and oil; stir into dry ingredients just until moistened. Fold in apples. Fill paper-lined muffin cups two-thirds full. In a small bowl, combine sugar, flour and cinnamon. Cut in butter until crumbly. Sprinkle over batter.',
                    'Bake at 350 degrees for 35-40 minutes or until golden brown. Cool for 5 minutes before removing from pans to wire racks.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('18');
        $recipe->setUrl('http://allrecipes.com/recipe/42273/apple-pumpkin-muffins/');

        $crawler = $this->client->request(
            'GET',
            'http://allrecipes.com/recipe/42273/apple-pumpkin-muffins/'
        );
        $scraper = new AllRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
