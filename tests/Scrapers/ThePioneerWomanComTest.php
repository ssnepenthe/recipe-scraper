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
}
