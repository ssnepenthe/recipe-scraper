<?php

use SSNepenthe\RecipeScraper\Scrapers\ThePioneerWomanCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class ThePioneerWomanComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT1H'));
        $recipe->setImage('https://pioneerwoman.files.wordpress.com/2016/05/dsc_0580.jpg?w=780&h=519');
        $recipe->setName('French Dip Sandwiches');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 Tablespoon Kosher Salt',
                    '2 Tablespoons Black Pepper',
                    '1/2 teaspoon Ground Oregano',
                    '1/2 teaspoon Ground Thyme',
                    '1 whole Boneless Ribeye Loin, About 4 To 5 Pounds (can Also Use Sirloin)',
                    '2 whole Large Onions, Sliced Thin',
                    '5 cloves Garlic, Minced',
                    '1 whole Packet French Onion Soup Mix (dry)',
                    '1 can Beef Consomme',
                    '1 cup Beef Broth Or Beef Stock',
                    '1/4 cup Dry Sherry Or White Wine (or You May Omit)',
                    '2 Tablespoons Worcestershire Sauce',
                    '1 Tablespoon Soy Sauce',
                    '1 cup Water',
                    '10 whole Crusty Deli Rolls/sub Rolls, Toasted',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat the oven to 475 degrees. Tie the piece of meat tightly with a couple of pieces of kitchen twine.',
                    'Mix the salt, pepper, oregano and thyme and rub it all over the surface of the beef. Place the beef on a roasting rack in a roasting pan and roast it to medium-rare, about 20 to 25 minutes, until it registers 125 degrees on a meat thermometer. (If you want it less pink, go to 135.) Remove the meat to a cutting board and cover it with foil.',
                    'Return the roasting pan to the stovetop burner over medium-high heat. Add the onions and garlic and stir them around for 5 minutes, until they are soft and golden. Sprinkle in the soup mix, then pour in the consomme, broth, sherry, Worcestershire, soy, and water. Bring it to a boil, then reduce the heat to low. Simmer for 45 minutes, stirring occasionally, to develop the flavors. Add more water if it starts to evaporate too much. Pour the liquid through a fine mesh strainer and reserve both the liquid and the onions.',
                    'Slice the beef very thin. Pile meat and onions on rolls, then serve with dishes of jus.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('10');
        $recipe->setUrl('http://thepioneerwoman.com/cooking/french-dip-sandwiches/');

        $crawler = $this->client->request(
            'GET',
            'http://thepioneerwoman.com/cooking/french-dip-sandwiches/'
        );
        $scraper = new ThePioneerWomanCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_parse_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setImage('https://pioneerwoman.files.wordpress.com/2016/03/dsc_3966.jpg?w=780&h=519');
        $recipe->setName('Cashew Chicken');
        $recipe->setPrepTime(new DateInterval('PT5M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/2 cup Low Sodium Soy Sauce',
                    '1 Tablespoon Rice Vinegar',
                    '1 Tablespoon Packed Brown Sugar',
                    '2 Tablespoons Oyster Sauce',
                    '1/2 teaspoon Toasted Sesame Oil',
                    '3 Tablespoons Vegetable Oil',
                    '6 whole Boneless, Skinless Chicken Thighs, Cut Into Small Cubes',
                    'Kosher Salt To Taste',
                    '1 Tablespoon Chopped Garlic',
                    '1 Tablespoon Chopped Fresh Ginger',
                    '1 whole Green Bell Pepper, Chopped',
                    '1/4 cup Sherry Or Chicken Broth',
                    '2 Tablespoons Cornstarch',
                    '1/2 cup Drained Canned Water Chestnuts, Coarsley Chopped',
                    '1 cup Unsalted Cashews (be Sure To Use Unsalted)',
                    '2 whole Green Onions, Thinly Sliced',
                    'Cooked Rice Or Noodles, For Serving (if Desired)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a bowl, mix together the soy sauce, vinegar, brown sugar, oyster sauce, and sesame oil. Set aside.',
                    'Heat the vegetable oil in a large skillet over high heat and add the chicken in a single layer. Sprinkle with a small amount of salt, then leave it alone for at least a couple of minutes to give the chicken a chance to brown. When the chicken has turned golden, stir it around so that it can brown on all sides. Throw in the garlic and ginger and stir to combine. Stir in the bell pepper and let it cook for 2 to 3 minutes.',
                    'While the pan is still hot, pour in the sherry. Stir it around, scraping the bottom of the pan to loosen all the flavorful bits. Turn the heat to medium-low and pour in the sauce mixture, then mix the cornstarch with 1/4 cup water to make a slurry and pour it in. Stir the sauce for 1 to 2 minutes to thicken, then add the water chestnuts and cashews and stir to coat everything with the sauce, adding a splash of water if the sauce is too thick.',
                    'Finally, sprinkle on the green onions. Serve with cooked rice or noodles.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('8');
        $recipe->setUrl('http://thepioneerwoman.com/cooking/cashew-chicken/');

        $crawler = $this->client->request(
            'GET',
            'http://thepioneerwoman.com/cooking/cashew-chicken/'
        );
        $scraper = new ThePioneerWomanCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_parse_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setImage('http://pioneerwoman.files.wordpress.com/2014/11/15806731655_2546b426c7_z.jpg?w=630&h=419');
        $recipe->setName('Pumpkin Sheet Cake');
        $recipe->setPrepTime(new DateInterval('PT35M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 sticks Salted Butter',
                    '2 cups Pumpkin Puree (not Pumpkin Pie Filling!)',
                    '2 teaspoons Pumpkin Pie Spice',
                    '3/4 cups Boiling Water',
                    '2 cups Flour',
                    '2 cups Sugar',
                    '1/4 teaspoon Salt',
                    '1/2 cup Buttermilk',
                    '2 whole Eggs',
                    '2 teaspoons Baking Soda',
                    '2 teaspoons Vanilla Extract',
                    '1/2 teaspoon Maple Extract (optional)',
                ],
            ],
            [
                'title' => 'Frosting',
                'data'  => [
                    '8 ounces, weight Cream Cheese, Softened',
                    '1 stick Butter, Softened',
                    '1 pound Powdered Sugar, Sifted',
                    'Dash Of Salt',
                    '1 Tablespoon Half-and-half Or Milk (more If Needed For Thinning)',
                ],
            ],

        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat oven to 350 degrees. Spray a sheet pan with baking spray and set aside.',
                    'In a medium saucepan, melt 2 sticks butter. Whisk in pumpkin and pumpkin pie spice until it\'s totally combined. Whisk in boiling water until mixture is smooth and combined. Set aside.',
                    'In a measuring pitcher, combine buttermilk, eggs, baking soda, vanilla, and maple extract. Whisk and set aside.',
                    'In a large bowl, combine flour, sugar, and salt. Pour in the pumpkin mixture and stir until halfway combined. Pour in the buttermilk mixture and stir until combined. Pour into the pan and bake the cake for 20 minutes. Remove and allow to cool.',
                    'To make the frosting, mix together the cream cheese, butter, powdered sugar, and salt until smooth. Add half and half and check the consistency. It should be somewhat thick but thin enough to spread in a thin layer.',
                    'Spread the frosting all over the surface of the cake. Cut into squares and serve. Keep leftovers in the fridge, as frosting will get soft.',
                    'NOTE: You may double the frosting amounts if you like a very thick layer of frosting!',
                ],
            ],
        ]);
        $recipe->setRecipeYield('18');
        $recipe->setUrl('http://thepioneerwoman.com/cooking/pumpkin-sheet-cake/');

        $crawler = $this->client->request(
            'GET',
            'http://thepioneerwoman.com/cooking/pumpkin-sheet-cake/'
        );
        $scraper = new ThePioneerWomanCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_parse_a_recipe_with_undetectable_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT2H'));
        $recipe->setImage('http://pioneerwoman.files.wordpress.com/2014/06/14456033103_d701528868_z.jpg?w=630&h=419');
        $recipe->setName('Blackberry Cheesecake Squares');
        $recipe->setPrepTime(new DateInterval('PT4H'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    'Crust',
                    '10 ounces, weight (2 Sleeves) Graham Crackers',
                    '1/2 cup Pecans Or Walnuts',
                    '1/2 cup Butter, Melted',
                    '1 teaspoon Vanilla Extract',
                    'Filling',
                    '3 packages (8 Ounces Each) Cream Cheese, Softened',
                    '1-1/2 cup Sugar',
                    '1-1/2 teaspoon Vanilla Extract',
                    '4 whole Eggs',
                    '1/2 cup Sour Cream',
                    'Topping',
                    '4 cups Blackberries',
                    '1 cup Sugar',
                    '1/4 cup Water',
                    '2 Tablespoons Cornstarch',
                    '4 Tablespoons Water',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat the oven to 350 degrees. Place a 9 x 13 inch pan (or other ovenproof pan) of hot water into the bottom rack.',
                    'For the crust, line a separate 9 x 13 inch baking pan with foil. Spray with cooking spray. Add the graham crackers and pecans to the bowl of a food processor. Pulse them until they\'re fine crumbs. Drizzle in melted butter, pulsing until it\'s all incorporated. Pulse in the vanilla. Pour the crumbs into the prepared pan and press the crumbs firmly into an even layer. Set aside.',
                    'Beat cream cheese, sugar, and vanilla together until smooth. Add eggs one at a time, beating after each addition. Add sour cream and beat until incorporated.',
                    'Pour the filling into the crust and smooth the surface. Bake for 45 minutes, then turn off the oven and leave the door closed for an additional 10 minutes. Finally, open the door halfway and leave it in the oven for an additional 10 minutes. Remove the cheesecake and let it cool completely.',
                    'For the topping, add blackberries, sugar, and 1/4 cup water to a saucepan. Bring it to a boil and cook until the juices thicken slightly, about 4-5 minutes. In a small bowl, mix the cornstarch with 4 tablespoons water to make a slurry, then add it to the berries. Let it boil for another 1 to 2 minutes, then turn off the heat and allow to cool.',
                    'Pour the blackberries over the cheesecake and place the pan into the fridge to chill and set for at least 2 hours. When ready to serve, remove the cheesecake from the pan by lifting the edges of the foil. Peel back the foil and use a long serrated knife to cut cheesecake into squares.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('16');
        $recipe->setUrl('http://thepioneerwoman.com/cooking/blackberry-cheesecake-squares/');

        $crawler = $this->client->request(
            'GET',
            'http://thepioneerwoman.com/cooking/blackberry-cheesecake-squares/'
        );
        $scraper = new ThePioneerWomanCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
