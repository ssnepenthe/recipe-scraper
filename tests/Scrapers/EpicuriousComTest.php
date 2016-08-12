<?php

use SSNepenthe\RecipeScraper\Scrapers\EpicuriousCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class EpicuriousComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Alison Roman');
        $recipe->setDescription('Chicken breasts aren\'t the only cut sold skinless and boneless. Thighs are, too. They\'re fattier than breasts, which means they\'re more flavorful; plus, they\'re less expensive. Put them to work in any fast weeknight preparation, starting with these spiced tacos.');
        $recipe->setImage('http://assets.epicurious.com/photos/54af451f4074bdfd06837f8c/master/pass/51175340_grilled-chicken-tacos_1x1.jpg');
        $recipe->setName('Grilled Chicken Tacos');
        $recipe->setPublisher('Bon Appétit');
        $recipe->setRecipeCategories([
            'Chicken',
            'Low Fat',
            'Kid-Friendly',
            'Quick & Easy',
            'Backyard BBQ',
            'Summer',
            'Grill',
            'Grill/Barbecue',
            'Healthy',
            'Tortillas',
            'Bon Appétit',
        ]);
        $recipe->setRecipeCuisines(['Mexican']);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 medium onion, cut into wedges, keeping root intact',
                    '2 garlic cloves, finely chopped',
                    '1 pound skinless, boneless chicken thighs',
                    '1 tablespoon cumin seeds, coarsely crushed',
                    '1 tablespoon vegetable oil',
                    '1 teaspoon kosher salt',
                    '1/2 teaspoon freshly ground black pepper',
                    '8 corn tortillas, warmed (for serving)',
                    '2 avocados, sliced (for serving)',
                    'Charred Tomatillo Salsa Verde (for serving)',
                    'Cilantro sprigs, sliced radishes, and lime wedges (for serving)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                     'Prepare grill for medium-high heat. Toss onion, garlic, chicken, cumin, oil, salt, and pepper in a medium bowl. Grill onion and chicken until cooked through and lightly charred, about 4 minutes per side.',
                    'Let chicken rest 5 minutes before slicing. Serve with tortillas, avocados, Charred Tomatillo Salsa Verde, cilantro, radishes, and lime wedges.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.epicurious.com/recipes/food/views/grilled-chicken-tacos-51175340');

        $crawler = $this->client->request(
            'GET',
            'http://www.epicurious.com/recipes/food/views/grilled-chicken-tacos-51175340'
        );
        $scraper = new EpicuriousCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Nancy Silverton');
        $recipe->setImage('http://assets.epicurious.com/photos/57aa356d47750f3f7bc358f6/master/pass/mozzarella-and-prosciutto-sandwiches-with-tapenade-09082016.jpg');
        $recipe->setName('Mozzarella and Prosciutto Sandwiches with Tapenade');
        $recipe->setPublisher('Bon Appétit');
        $recipe->setRecipeCategories([
            'Sandwich',
            'Cheese',
            'Olive',
            'Pork',
            'No-Cook',
            'Quick & Easy',
            'Back to School',
            'Lunch',
            'Fall',
            'Summer',
            'Bon Appétit',
        ]);
        $recipe->setRecipeCuisines([
            'American',
            'Italian',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 1/2 teaspoons chopped anchovy fillet',
                    '1 teaspoon capers (preferably salt-packed), rinsed, chopped',
                    '1 garlic clove, minced',
                    '1 teaspoon finely grated lemon peel',
                    '1/2 teaspoon finely grated orange peel',
                    '1 1/4 cups Niçoise olives, pitted, divided',
                    '1/4 cup extra-virgin olive oil plus additional for brushing and drizzling',
                    '1 tablespoon (packed) chopped fresh basil plus 24 whole leaves for garnish',
                    '24 basil leaves',
                    '2 teaspoons fresh lemon juice',
                    '6 6-inch-long pieces ficelle or narrow baguette, split horizontally in half',
                    '6 thin prosciutto slices',
                    '2 8-ounce balls fresh mozzarella cheese, drained, cut into 1/3-inch-thick slices',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Combine first 5 ingredients in mortar; mash with pestle to paste. Add 1 cup olives and mash to coarse paste. Chop remaining 1/4 cup olives and stir into mixture. Mix in 1/4 cup olive oil, chopped basil, and lemon juice. Season tapenade with pepper. (Can be made 2 weeks ahead. Cover and refrigerate.)',
                    'Brush cut sides of ficelle with additional olive oil. Place 1 prosciutto slice on bottom half of each ficelle, then top with mozzarella slices, dividing equally. Spoon tapenade over each. Sprinkle with pepper; drizzle lightly with olive oil. Garnish with basil leaves. Cover with top halves of ficelle.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://www.epicurious.com/recipes/food/views/mozzarella-and-prosciutto-sandwiches-with-tapenade-234141');

        $crawler = $this->client->request(
            'GET',
            'http://www.epicurious.com/recipes/food/views/mozzarella-and-prosciutto-sandwiches-with-tapenade-234141'
        );
        $scraper = new EpicuriousCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Katherine Sacks');
        $recipe->setDescription('This version of our delicious vanilla-buttermilk cake is simply topped with a swoosh of orange cream-cheese frosting and raspberries. It\'s so easy to serve right out of the pan, which makes it perfect for backyard barbecues and potlucks.');
        $recipe->setImage('http://assets.epicurious.com/photos/57719d947823d8090d928cd9/master/pass/Vanilla-Buttermilk-Cake-Raspberries-27062016.jpg');
        $recipe->setName('Vanilla-Buttermilk Sheet Cake With Raspberries and Orange Cream-Cheese Frosting');
        $recipe->setPublisher('Epicurious');
        $recipe->setRecipeCategories([
            'Cake',
            'Birthday',
            'Raspberry',
            'Orange',
            'Cream Cheese',
            'Vanilla',
            'Dessert',
            'Summer',
            'Potluck',
            'Buttermilk',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Buttermilk Cake',
                'data' => [
                    '2 cups cake flour, plus more for pan',
                    '1 teaspoon baking powder',
                    '1/2 teaspoon baking soda',
                    '1/4 teaspoon kosher salt',
                    '3/4 cup (1 1/2 sticks) unsalted butter, room temperature',
                    '1 3/4 cups granulated sugar, divided',
                    '4 large eggs, separated',
                    '1 teaspoon vanilla extract',
                    '1 cup buttermilk',
                ],
            ],
            [
                'title' => 'For The Vanilla Syrup',
                'data' => [
                    '1/4 cup granulated sugar',
                    '1 vanilla bean, split lengthwise',
                ],
            ],
            [
                'title' => 'For The Orange Cream-cheese Frosting',
                'data' => [
                    '1 (8-ounce) package cream cheese, chilled',
                    '5 tablespoons unsalted butter, room temperature',
                    '1/2 teaspoon finely grated orange zest',
                    '1 1/2 teaspoons fresh orange juice',
                    '1/2 teaspoon vanilla extract',
                    '6 Tbsp. powdered sugar, sifted',
                ],
            ],
            [
                'title' => 'For The Assembly',
                'data' => [
                    '4 ounces raspberries',
                    'Edible flowers (for garnish; optional)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'Bake The Buttermilk Cake',
                'data' => [
                    'Place a rack in middle of oven; preheat to 350 °F. Flour a 13x9" pan, tapping out excess. Whisk baking powder, baking soda, salt, and remaining 2 cups flour in a medium bowl; set aside.',
                    'Using an electric mixer on medium-high speed, beat butter and 1 1/2 cups granulated sugar in a large bowl, scraping down sides of bowl as needed, until light and creamy, about 5 minutes. Add egg yolks in 2 additions, scraping down bowl after each. Beat in vanilla.',
                    'Reduce mixer speed to low, then add dry ingredients in 2 additions alternately with buttermilk in 2 additions, scraping down sides of bowl as needed.',
                    'Using electric mixer on medium speed, beat egg whites in another large bowl until soft peaks form, 2 –3 minutes. Slowly add remaining 1/4 cup granulated sugar and continue to beat until stiff, glossy peaks form, about 3 minutes more. Fold half of the egg whites into flour mixture, then gently fold in remaining egg whites.',
                    'Scrape batter into prepared pan; smooth surface. Bake, rotating pan halfway through and covering with foil during the last 15 minutes of baking, until golden brown, firm to the touch, and a tester inserted into the center comes out clean, 35 –40 minutes. Transfer pan to a wire rack and let cake cool.',
                ],
            ],
            [
                'title' => 'Make The Vanilla Syrup',
                'data' => [
                    'Combine granulated sugar and 1/4 cup water in a medium saucepan. Scrape in vanilla seeds, add pod, and stir to combine. Bring to a boil, cover, and steep at least 15 minutes. Set aside to cool. Discard pod before using.',
                ],
            ],
            [
                'title' => 'Make The Orange Cream-cheese Frosting',
                'data' => [
                    'Using electric mixer on medium-high speed, beat cream cheese and butter in a large bowl until smooth, about 1 minute. Beat in orange zest, orange juice, and vanilla. Reduce mixer speed to low and beat in powdered sugar, scraping down bowl as needed, until light and fluffy, 2 –3 minutes.',
                ],
            ],
            [
                'title' => 'Assemble The Cake',
                'data' => [
                    'Using a pastry brush, brush top of cooled cake with 2 Tbsp. vanilla syrup; reserve remaining syrup for another use. Spread frosting over top of cake, swirling decoratively. Top with raspberries and edible flowers, if using.',
                ],
            ],
            [
                'title' => 'Do Ahead',
                'data' => [
                    'Cake can be made 3 days ahead; wrap tightly in plastic and chill, or freeze up to 2 weeks. Syrup can be made 5 days ahead; store in an airtight container and chill. Frosting can be made 3 days ahead; cover with plastic wrap, pressing directly on surface, and chill. Bring to room temperature before using.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('1 (13x9") cake');
        $recipe->setUrl('http://www.epicurious.com/recipes/food/views/vanilla-buttermilk-sheet-cake-with-raspberries-and-orange-cream-cheese-frosting');

        $crawler = $this->client->request(
            'GET',
            'http://www.epicurious.com/recipes/food/views/vanilla-buttermilk-sheet-cake-with-raspberries-and-orange-cream-cheese-frosting'
        );
        $scraper = new EpicuriousCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setImage('http://assets.epicurious.com/photos/577e81394f2c1eb16e3d5851/master/pass/plum-steusel-coffeecake-hero-07072016.jpg');
        $recipe->setName('Plum Streusel Coffeecake');
        $recipe->setPublisher('Gourmet');
        $recipe->setRecipeCategories([
            'Cake',
            'Food Processor',
            'Mixer',
            'Dairy',
            'Breakfast',
            'Brunch',
            'Dessert',
            'Bake',
            'Vegetarian',
            'Plum',
            'Walnut',
            'Fall',
            'Gourmet',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'For Streusel',
                'data' => [
                    '1 cup all-purpose flour',
                    '1/2 cup firmly packed light brown sugar',
                    '1/2 cup walnuts',
                    '3/4 stick (6 tablespoons) unsalted butter, cut into pieces and softened',
                    '1 teaspoon cinnamon',
                    '1/4 teaspoon freshly grated nutmeg',
                ],
            ],
            [
                'title' => 'For Cake Batter',
                'data' => [
                    '1 stick (1/2 cup) unsalted butter, softened',
                    '3/4 cup granulated sugar',
                    '2 large eggs',
                    '1 teaspoon vanilla',
                    '1 1/4 cups all-purpose flour',
                    '1 teaspoon baking powder',
                    '1/2 teaspoon salt',
                    '3/4 pound plums (4 to 5 medium), sliced',
                    'confectioners\' sugar for sifting over cake',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Preheat oven to 350 °F. and butter and flour a 9-inch round or square baking pan at least 2 inches deep.',
                ],
            ],
            [
                'title' => 'Make Streusel',
                'data' => [
                    'In a food processor pulse together streusel ingredients until combined well and crumbly.',
                ],
            ],
            [
                'title' => 'Make Cake Batter',
                'data' => [
                    'In a bowl with an electric mixer beat butter with sugar until light and fluffy and add eggs, 1 at a time, beating well after each addition, and vanilla. Sift in flour with baking powder and salt and beat until just combined.',
                    'Spread cake batter in pan, smoothing top, and arrange plum slices over it in slightly overlapping concentric circles. Sprinkle streusel over plum slices and bake cake in middle of oven 1 hour, or until a tester comes out clean. Coffeecake may be made 1 week ahead: Cool cake completely in pan on a rack and freeze, wrapped well in plastic wrap and foil. Reheat cake, unwrapped but not thawed, in a preheated 350 °F. oven until heated through, 35 to 40 minutes. Cool cake slightly on a rack and sift confectioners\' sugar over it. Serve coffeecake warm or at room temperature.',
                ],
            ],
        ]);
        $recipe->setUrl('http://www.epicurious.com/recipes/food/views/plum-streusel-coffeecake-13137');

        $crawler = $this->client->request(
            'GET',
            'http://www.epicurious.com/recipes/food/views/plum-streusel-coffeecake-13137'
        );
        $scraper = new EpicuriousCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
