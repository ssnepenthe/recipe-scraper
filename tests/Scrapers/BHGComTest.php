<?php

use SSNepenthe\RecipeScraper\Scrapers\BHGCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class BHGComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Editors of Better Homes & Gardens');
        $recipe->setCookTime(new DateInterval('PT240M'));
        $recipe->setDescription('For more of the flavor of Germany, heat Bavarian-style sauerkraut to serve along with the well-seasoned pork and tangy gravy.');
        $recipe->setImage('http://images.meredith.com/content/dam/bhg/Images/recipe/38/37352.jpg.rendition.largest.ss.jpg');
        $recipe->setName('Bavarian Pork Roast');
        $recipe->setPrepTime(new DateInterval('PT25M'));
        $recipe->setRecipeCategories([
            'Dinner Recipes',
            'Ethnic Recipes',
            'Healthy Dinners',
            'Healthy Recipes',
            'Heart Healthy Dinners',
            'Heart-Healthy Recipes',
            'Low Fat Recipes',
            'Pork Recipes',
            'Quick and Easy Dinners',
            'Quick and Easy Healthy Dinner Recipes',
            'Slow Cooker Recipes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 1 1/2 pound boneless pork shoulder roast',
                    '2 teaspoons caraway seed',
                    '1 teaspoon dried marjoram, crushed',
                    '3/4 teaspoon salt',
                    '1/2 teaspoon pepper',
                    '1 tablespoon olive oil or cooking oil',
                    '1/2 cup water',
                    '2 tablespoons white wine vinegar',
                    '1 ounce carton dairy sour cream or plain yogurt',
                    '4 teaspoons cornstarch',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Trim fat from roast. If necessary, cut roast to fit into a 3-1/2- to 6-quart crockery cooker. Combine caraway seed, marjoram, salt, and pepper. Rub all over roast.',
                    'In a large skillet, brown pork roast on all sides in hot oil. Drain off fat. Place meat in crockery cooker. Add the water to skillet; bring to a gentle boil over medium heat, stirring to loosen brown bits in bottom of skillet. Pour skillet juices and vinegar into crockery cooker.',
                    'Cover and cook on low-heat setting for 8 to 10 hours or on high-heat setting for 4 to 5 hours. Remove meat from cooker; keep warm.',
                    'For gravy, skim fat from juices; measure 1-1/4 cups juices (add water, if necessary). Pour juices into a saucepan; bring to boiling. Combine sour cream or yogurt and cornstarch. Stir into juices. Cook and stir over medium heat until thickened and bubbly. Cook and stir 2 minutes more. Slice meat and serve with gravy. Makes 6 servings.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://www.bhg.com/recipe/meat/bavarian-pork-roast/');

        $crawler = $this->client->request(
            'GET',
            'http://www.bhg.com/recipe/meat/bavarian-pork-roast/'
        );
        $scraper = new BHGCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
