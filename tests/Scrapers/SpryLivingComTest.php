<?php

use SSNepenthe\RecipeScraper\Scrapers\SpryLivingCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class SpryLivingComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Our Cookbook Collection');
        $recipe->setImage('http://i2.wp.com/spryliving.com/wp-content/uploads/2016/05/unnamed.jpg?resize=670%2C405');
        $recipe->setName('Grilled Salmon with Garlic-Kale Pesto and Summer Squash');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
					'coconut oil, for grilling',
					'2 cups garlic scapes',
					'2 cups packed kale leaves',
					'1/2 cup olive oil',
					'1/2 cup grated Parmesan or pecorino Romano cheese',
					'1/4 teaspoon salt',
					'1/8 teaspoon freshly ground black pepper',
					'1 pound (4 filets) wild salmon, skin intact',
					'1 pound yellow squash, sliced into 1/4-inch strips',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
					'Oil a grill with coconut oil and preheat the grill over high heat.',
					'Put the garlic scapes, kale, olive oil, cheese, salt, and pepper in a food processor or blender and process until finely chopped. Divide the pesto in half and reserve one-half for another use.',
					'Place the salmon on the grill, flesh side down, and grill 3 to 4 minutes. Turn the salmon, and place the squash slices on the grill. Brush the pesto over the salmon and the squash. Grill the squash, turning it occasionally, for 4 to 5 minutes until cooked through. Grill the salmon 4 to 5 minutes until the skin crisps but the center is still medium. Transfer to a plate and serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://spryliving.com/recipes/grilled-salmon-with-pesto/');

        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/grilled-salmon-with-pesto/'
        );
        $scraper = new SpryLivingCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Our Cookbook Collection');
        $recipe->setImage('http://i2.wp.com/spryliving.com/wp-content/uploads/2016/05/ramsey_eat-complete_chipotle-pork-loin.jpg?resize=670%2C405');
        $recipe->setName('Grilled Pork Loin with Blueberry-Kiwi Salsa');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 kiwis, peeled and diced',
                    '1 pint blueberries, chopped',
                    '1/2 cup cilantro leaves, chopped',
                    '1/4 cup red onion, minced',
                    '2 tablespoons balsamic vinegar',
                    '1 teaspoon salt',
                    '3/4 teaspoon paprika or chipotle chile powder',
                    '1/2 teaspoon ground turmeric',
                    '1/2 teaspoon ground cumin',
                    '1/4 teaspoon freshly ground black pepper',
                    '1 two pound, center-cut pork loin',
                    '2 tablespoons grapeseed oil, plus more for grilling',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'To grill the pork loin, preheat a grill over high heat, or to roast, preheat the oven to 400˚F.',
                    'Combine the kiwis, blueberries, cilantro, onion, and vinegar in a large bowl. Add 1/4 teaspoon of the salt and toss well. Set the salsa aside. Place the paprika or chipotle chile powder on a plate along with the turmeric, cumin, the remaining 3/4 teaspoon salt, and the black pepper. Roll the pork loin in the spice mixture to coat. Drizzle the pork with the oil.',
                    'TO GRILL: Grease the grill with grapeseed oil. Adjust the grill flame setting to medium to medium low. Place the loin on the grill and cook, turning often, until no longer translucent inside and cooked through, or until it registers 145˚F on an instant-read thermometer, 20 to 25 minutes. Let the loin rest for 5 minutes before slicing, then serve with the salsa.',
                    'TO ROAST: Place the pork in a 7 × 11-inch baking dish and roast on the lower rack, uncovered, for 35 to 40 minutes until cooked through and no longer pink in the center, and it registers 145˚F on an instant-read thermometer. Let the loin rest for 5 minutes before slicing, then serve with the salsa.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://spryliving.com/recipes/grilled-chipotle-pork-loin/');

        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/grilled-chipotle-pork-loin/'
        );
        $scraper = new SpryLivingCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_and_isntruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('eMeals');
        $recipe->setCookTime(new DateInterval('PT5M'));
        $recipe->setImage('http://i0.wp.com/spryliving.com/wp-content/uploads/2016/04/blt.jpg?resize=631%2C405');
        $recipe->setName('Paleo Grilled Chicken BLT');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '8 slices nitrite-free bacon',
                    '1/4 cup olive oil mayonnaise (or use a homemade Paleo Mayonnaise)',
                    '2 tablespoons chopped fresh basil',
                    '4 grilled chicken breasts',
                    '1 cup baby spinach',
                    '2 large tomatoes, cut into 8 slices',
                ],
            ],
            [
                'title' => 'Romaine Salad With Lemon Vinaigrette',
                'data'  => [
                    '2 tablespoons fresh lemon juice',
                    '2 tablespoons extra virgin olive oil',
                    '1/2 teaspoon Dijon mustard',
                    '1 clove garlic, minced',
                    '1/4 teaspoon salt',
                    '1/4 teaspoon pepper',
                    '4 cups chopped romaine lettuce',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'For The Sandwich',
                'data'  => [
                    'Place 4 slices bacon on a paper towel-lined plate; microwave on High 1 1/2 to 2 minutes or until crisp. Repeat with remaining bacon. Combine mayonnaise and basil.',
                    'If needed, reheat grilled chicken in microwave at HIGH 1 to 2 minutes or until heated.',
                    'Butterfly chicken breasts. Spread mayonnaise mixture evenly over cuts sides of chicken breasts. Layer spinach, sliced tomato and bacon inside of chicken breasts.',
                ],
            ],
            [
                'title' => 'For The Side Salad',
                'data'  => [
                    'Combine lemon juice, oil, mustard, garlic, salt and pepper in a large bowl; whisk until blended.',
                    'Add lettuce; toss to coat.',
                ],
            ],
        ]);
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://spryliving.com/recipes/blt-paleo-chicken-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/blt-paleo-chicken-recipe/'
        );
        $scraper = new SpryLivingCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('eMeals');
        $recipe->setCookTime(new DateInterval('PT30M'));
        $recipe->setImage('http://i2.wp.com/spryliving.com/wp-content/uploads/2016/04/caprese.png?resize=670%2C405');
        $recipe->setName('Baked Caprese Chicken with Lemon Green Beans and Parmesan Polenta');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 1/2 pounds boneless, skinless chicken breasts',
                    '1/2 teaspoon salt',
                    '1/2 teaspoon pepper',
                    '3 large Roma tomatoes, sliced',
                    '1 (1-oz) pkg fresh basil, thinly sliced (or use leaves whole)',
                    '1 (8-oz) ball fresh mozzarella cheese, thinly sliced (or use block mozzarella)',
                    '2 tablespoons olive oil',
                    '3 tablespoons balsamic vinegar',
                ],
            ],
            [
                'title' => 'Lemon Green Beans And Parmesan Polenta',
                'data'  => [
                    '3/4 cup uncooked polenta',
                    '1/2 teaspoon salt, divided',
                    '1/2 teaspoon pepper, divided',
                    '1/4 cup freshly grated Parmesan cheese',
                    '2 pounds fresh green beans, trimmed',
                    '1 tablespoon olive oil',
                    '1 tablespoon fresh lemon juice',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'For The Chicken',
                'data'  => [
                    'Preheat oven to 350 °F. Place chicken in a 13- x 9-inch baking dish coated with cooking spray; sprinkle with salt and pepper.',
                    'Top with tomatoes, basil, and mozzarella; drizzle with olive oil.',
                    'Bake 30 minutes or until chicken is done; drizzle with vinegar before serving.',
                ],
            ],
            [
                'title' => 'For The Green Beans',
                'data'  => [
                    'Bring 3 cups water to a boil in a large saucepan; whisk in polenta and 1/4 tsp each salt and pepper. Return to a boil, reduce heat, and simmer until liquid is absorbed, stirring occasionally. Stir in cheese.',
                    'Arrange green beans in a steamer basket over boiling water. Cover and steam 5 minutes or until crisp-tender.',
                    'Drain and transfer to a serving bowl. Drizzle with olive oil and lemon juice; sprinkle with remaining 1/4 tsp each salt and pepper.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://spryliving.com/recipes/baked-caprese-chicken/');

        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/baked-caprese-chicken/'
        );
        $scraper = new SpryLivingCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
