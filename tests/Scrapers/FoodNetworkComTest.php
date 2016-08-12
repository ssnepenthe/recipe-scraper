<?php

use SSNepenthe\RecipeScraper\Scrapers\FoodNetworkCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class FoodNetworkComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Food Network Kitchen');
        $recipe->setCookTime(new DateInterval('PT1H10M'));
        $recipe->setImage('http://foodnetwork.sndimg.com/content/dam/images/food/fullset/2010/6/8/5/FNM_070110-Weekend-Dinners-026_s4x3.jpg.rend.sni12col.landscape.jpeg');
        $recipe->setName('Crunchy Lemonade Drumsticks');
        $recipe->setPrepTime(new DateInterval('PT35M'));
        $recipe->setRecipeCategories(['Chicken', 'Easy']);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 tablespoons grated lemon zest',
                    '1/2 cup fresh lemon juice',
                    '3 tablespoons packed light brown sugar',
                    '1/3 cup buttermilk',
                    '12 skin-on chicken drumsticks (3 1/2 to 4 1/4 pounds)',
                    'Kosher salt and freshly ground black pepper',
                    '2 cups panko (Japanese breadcrumbs)',
                    '1 tablespoon chopped fresh thyme',
                    'Pinch of cayenne pepper',
                    '1/4 cup mayonnaise',
                    'Olive-oil cooking spray',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Mix 1 tablespoon lemon zest and the lemon juice in a large bowl. Add 1 cup water and the sugar and whisk to dissolve, then whisk in the buttermilk. Pierce the drumsticks several times with a fork and season with salt and pepper. Toss in the marinade, cover and refrigerate 4 hours, or overnight.',
                    'Preheat the oven to 400 degrees F. Bring the chicken to room temperature. Put the panko, thyme, the remaining 1 tablespoon lemon zest, the cayenne, 1 teaspoon salt, and black pepper to taste in a large resealable plastic bag and shake to mix. Put the mayonnaise in a bowl. Set a rack on a baking sheet and spray with cooking spray.',
                    'Remove the drumsticks from the marinade, dip in the mayonnaise, then drop into the bag and shake to coat; transfer to the rack.',
                    'Mist the chicken with cooking spray. Bake until golden, about 35 minutes; flip and bake until browned and crisp, 35 to 40 more minutes. Cool completely, then pack in an airtight container.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setTotalTime(new DateInterval('PT1H45M'));
        $recipe->setUrl('http://www.foodnetwork.com/recipes/food-network-kitchens/crunchy-lemonade-drumsticks-recipe.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodnetwork.com/recipes/food-network-kitchens/crunchy-lemonade-drumsticks-recipe.html'
        );
        $scraper = new FoodNetworkCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Food Network Kitchen');
        $recipe->setCookTime(new DateInterval('PT15M'));
        $recipe->setImage('http://foodnetwork.sndimg.com/content/dam/images/food/fullset/2010/3/3/0/FNM_040110-W-N-Dinners-025_s4x3.jpg.rend.sni12col.landscape.jpeg');
        $recipe->setName('Sausage-and-Pepper Skewers');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeCategories([
            'Sausage',
            'Main Dish',
            'Grilling',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 cup couscous',
                    '2 bell peppers (red and yellow), cut into chunks',
                    '1 (12-ounce) package chicken sausage (preferably garlic-flavored), cut into 1-inch pieces',
                    '1 large red onion, cut into chunks',
                    '1 cup cherry tomatoes',
                    '3 tablespoons extra-virgin olive oil',
                    'Kosher salt and freshly ground pepper',
                    '1/4 cup fresh parsley',
                    '1/4 cup fresh cilantro',
                    '4 scallions, roughly chopped',
                    '1 tablespoon white wine vinegar',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Soak eight 8-inch skewers in water, at least 15 minutes. Preheat a grill or grill pan to medium high. Prepare the couscous as the label directs.',
                    'Meanwhile, toss the bell peppers, sausage, onion and tomatoes in a bowl with 1 tablespoon olive oil; season with salt and pepper. Thread onto the skewers, alternating the sausage and vegetables. Grill, turning, until the vegetables are slightly softened and the sausage begins to brown, 6 to 7 minutes.',
                    'Meanwhile, puree the parsley, cilantro and scallions in a blender with the remaining 2 tablespoons olive oil, the vinegar and 2 tablespoons water. Season with salt and pepper. Brush the skewers with some of the pesto and continue to cook, turning, until the tomatoes are tender and the sausage is charred, 6 to 7 more minutes.',
                    'Toss the couscous with half of the remaining pesto and season with salt and pepper. Serve with the skewers and the remaining pesto, for dipping.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT45M'));
        $recipe->setUrl('http://www.foodnetwork.com/recipes/food-network-kitchens/sausage-and-pepper-skewers-recipe.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodnetwork.com/recipes/food-network-kitchens/sausage-and-pepper-skewers-recipe.html'
        );
        $scraper = new FoodNetworkCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Ree Drummond');
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setImage('http://foodnetwork.sndimg.com/content/dam/images/food/fullset/2013/4/10/0/WU0413H_billies-italian-cream-cake-with-blueberries-recipe_s4x3.jpg.rend.sni12col.landscape.jpeg');
        $recipe->setName('Billie\'s Italian Cream Cake with Blueberries');
        $recipe->setPrepTime(new DateInterval('PT1H30M'));
        $recipe->setRecipeCategories([
            'Blueberry',
            'Dessert',
            'Cake',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake',
                'data'  => [
                    '5 eggs, separated',
                    '1 stick butter',
                    '1 cup vegetable oil',
                    '1 cup granulated sugar',
                    '1 tablespoon vanilla extract',
                    '1 cup sweetened flaked coconut',
                    '2 cups all-purpose flour',
                    '1 teaspoon baking soda',
                    '1 teaspoon baking powder',
                    '1 cup buttermilk (or 1 cup milk mixed with1 teaspoon white vinegar)',
                ],
            ],
            [
                'title' => 'Frosting',
                'data'  => [
                    'Two 8-ounce packages cream cheese',
                    '1 stick butter',
                    '2 teaspoons vanilla extract',
                    '2 pounds powdered sugar',
                    '1 cup chopped pecans',
                    '1 cup sweetened flaked coconut',
                    '1 1/2 pints or 3 small containers blueberries',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'For the cake: Preheat the oven to 350 degrees. Grease and flour two 9-inch round cake pans.',
                    'Beat the egg whites until stiff. Set aside.',
                    'In a large bowl, cream together the butter, oil and granulated sugar until light and fluffy. Mix in the egg yolks, vanilla and coconut.',
                    'In a separate bowl, mix the flour, baking soda and baking powder. Alternate adding the buttermilk and dry ingredients to the wet ingredients. Mix until just combined, and then fold in the egg whites.',
                    'Pour evenly into the prepared pans and bake until a toothpick comes out clean, 20 to 25 minutes. Remove from the oven and allow to cool for 15 minutes. Then turn the cakes out onto cooling racks and allow to cool completely.',
                    'For the frosting: In a medium bowl, combine the cream cheese, butter, vanilla and powdered sugar. Beat until light and fluffy. Stir in the pecans and coconut.',
                    'To assemble: Cut each cake in half lengthwise so you are left with 4 layers. Spread the first layer with frosting and top with blueberries. Repeat the cake, frosting and blueberry layers until you have 4 layers of cake. Arrange more blueberries around the edge of each layer for structure.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('12');
        $recipe->setTotalTime(new DateInterval('PT1H55M'));
        $recipe->setUrl('http://www.foodnetwork.com/recipes/ree-drummond/billies-italian-cream-cake-with-blueberries-recipe.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodnetwork.com/recipes/ree-drummond/billies-italian-cream-cake-with-blueberries-recipe.html'
        );
        $scraper = new FoodNetworkCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Bobby Flay');
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setImage('http://foodnetwork.sndimg.com/content/dam/images/food/fullset/2008/6/20/0/GrilledCornCob.jpg.rend.sni12col.landscape.jpeg');
        $recipe->setName('Perfectly Grilled Corn on the Cob');
        $recipe->setPrepTime(new DateInterval('PT1H10M'));
        $recipe->setRecipeCategories([
            'Corn',
            'Side Dish',
            'Grilling',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '8 ears corn',
                    'Kosher salt',
                    'BBQ Butter, recipe follows',
                    'Herb Butter, recipe follows',
                ],
            ],
            [
                'title' => 'Bbq Butter',
                'data'  => [
                    '2 tablespoons canola oil',
                    '1/2 small red onion, chopped',
                    '2 cloves garlic, chopped',
                    '2 teaspoons Spanish paprika',
                    '1/2 teaspoon cayenne powder',
                    '1 teaspoon toasted cumin seeds',
                    '1 tablespoon ancho chili powder',
                    '1/2 cup water',
                    '1 1/2 sticks unsalted butter, slightly softened',
                    '1 teaspoon Worcestershire sauce',
                    'Salt and freshly ground black pepper',
                ],
            ],
            [
                'title' => 'Herb Butter',
                'data'  => [
                    '2 sticks unsalted butter, at room temperature',
                    '1/4 cup chopped fresh herbs (basil, chives or tarragon)',
                    '1 teaspoon kosher salt',
                    'Freshly ground black pepper',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat the grill to medium.',
                    'Pull the outer husks down the ear to the base. Strip away the silk from each ear of corn by hand. Fold husks back into place, and place the ears of corn in a large bowl of cold water with 1 tablespoon of salt for 10 minutes.',
                    'Remove corn from water and shake off excess. Place the corn on the grill, close the cover and grill for 15 to 20 minutes, turning every 5 minutes, or until kernels are tender when pierced with a paring knife. Remove the husks and eat on the cob or remove the kernels. Serve with the BBQ Butter and/or Herb Butter. Spread over the corn while hot.',
                ],
            ],
            [
                'title' => 'Bbq Butter',
                'data' => [
                    'Heat the oil in a medium saute pan over high heat until almost smoking. Add the onion and cook until soft, 2 to 3 minutes. Add the garlic and cook for 30 seconds. Add the paprika, cayenne, cumin and ancho powder and cook for 1 minute. Add 1/2 cup of water and cook until the mixture becomes thickened and the water reduces. Let cool slightly.',
                    'Place the butter in a food processor, add the spice mixture and Worcestershire sauce and process until smooth. Season with salt and pepper, scrape the mixture into a small bowl, cover and refrigerate for at least 30 minutes to allow the flavors to meld. Bring to room temperature before serving.',
                ],
            ],
            [
                'title' => 'Herb Butter',
                'data' => [
                    'Combine in a food processor and process until smooth.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4 to 6');
        $recipe->setTotalTime(new DateInterval('PT1H35M'));
        $recipe->setUrl('http://www.foodnetwork.com/recipes/bobby-flay/perfectly-grilled-corn-on-the-cob-recipe.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.foodnetwork.com/recipes/bobby-flay/perfectly-grilled-corn-on-the-cob-recipe.html'
        );
        $scraper = new FoodNetworkCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
