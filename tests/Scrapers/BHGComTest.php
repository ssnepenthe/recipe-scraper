<?php

use SSNepenthe\RecipeScraper\Scrapers\BHGCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

/**
 * @todo Haven't been able to find recipes with ingredient groups.
 */
class BHGComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Better Homes and Gardens');
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

        $scraped = $scraper->scrape();

        $this->assertEquals($recipe, $scraped);
        $this->assertEquals(new DateInterval('PT4H25M'), $scraped->totalTime);
    }

    public function test_parse_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Better Homes and Gardens');
        $recipe->setDescription('Flavors meld beautifully when you roast the apples alongside the seasoned pork in this easy, low-calorie dinner recipe.');
        $recipe->setImage('http://images.meredith.com/content/dam/bhg/Images/recipe/43/R137745.jpg.rendition.largest.ss.jpg');
        $recipe->setName('Roasted Pork with Apples');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeCategories([
            'Diabetic Recipes',
            'Dinner Recipes',
            'Fruit Salad Recipes',
            'Healthy Breakfast Recipes',
            'Healthy Dinner Recipes',
            'Healthy Lunch Recipes',
            'Healthy Recipes',
            'Heart-Healthy Recipes',
            'Low Fat Recipes',
            'Pork Recipes',
            'Quick and Easy Healthy Recipes',
            'Quick and Easy Recipes',
            'Seasonal Recipes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 teaspoon snipped fresh sage or 1/2 teaspoon dried sage, crushed',
                    '1/4 teaspoon salt',
                    '1/4 teaspoon coarsely ground black pepper',
                    '1 1 pound pork tenderloin',
                    '1 tablespoon canola oil',
                    '1 medium red onion, cut into thin wedges',
                    '3 medium (1 pound) cooking apples (such as Granny Smith or Jonathan), cored and cut into 1/2-inch thick wedges',
                    '2/3 cup apple juice or apple cider',
                    'Fresh sage sprigs (optional)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'In a small bowl, combine the snipped sage, salt, and pepper; rub on all sides of tenderloin. In a large skillet brown tenderloin in hot oil over medium heat, turning to brown all sides.',
                    'Transfer pork to a shallow roasting pan. Add onion to pan around pork. Roast, uncovered, at 425 degrees F for 10 minutes. Stir in apples; roast for 10 to 15 minutes more or until pork internal temperature registers 155 degrees F on instant read thermometer and juices run clear.',
                    'Transfer pork and apple mixture to serving platter; cover with foil. Let stand for 10 minutes before slicing (temperature of the meat will rise 5 degrees F while it stands).',
                    'In a small saucepan bring apple juice to a boil; simmer gently, uncovered, for 8 to 10 minutes or until reduced to 1/4 to 1/3 cup. Drizzle over meat and apple mixture. If desired, garnish with additional sage sprigs.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.bhg.com/recipe/pork/roasted-pork-with-apples/');

        $crawler = $this->client->request(
            'GET',
            'http://www.bhg.com/recipe/pork/roasted-pork-with-apples/'
        );
        $scraper = new BHGCom($crawler);

        $scraped = $scraper->scrape();

        $this->assertEquals($recipe, $scraped);
    }
}
