<?php

use SSNepenthe\RecipeScraper\Scrapers\CookingChannelTVCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class CookingChannelTVComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setImage('http://cook.sndimg.com/content/dam/images/cook/fullset/2016/1/7/0/CCTIA206H_Lamb-Burger_s4x3.jpg/jcr:content/renditions/cq5dam.web.266.200.jpeg');
        $recipe->setName('Lamb Burgers');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
					'2 tablespoons finely chopped onion',
					'2 large cloves garlic, minced',
					'2 tablespoons chopped fresh parsley',
					'1 tablespoon chopped fresh mint',
					'1 tablespoon spicy brown mustard',
					'1 teaspoon prepared horseradish',
					'1 teaspoon Worcestershire sauce',
					'1 teaspoon kosher salt',
					'1/2 teaspoon ground cumin',
					'1/2 teaspoon freshly ground pepper',
					'1 egg, lightly beaten',
					'1 pound ground lamb',
					'4 tablespoons crumbled blue cheese',
					'1 tablespoon butter',
					'1 tablespoon canola oil',
					'4 brioche hamburger buns, halved',
					'4 leaves lettuce',
					'1 medium red onion, sliced',
					'1 large beefsteak tomato, sliced 1/4- to 1/2-inch thick',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
					'In a medium bowl, mix together the onion, garlic, parsley, mint, mustard, horseradish, Worcestershire, salt, cumin, pepper and egg. Add the lamb and mix well with your hands.',
					'Shape the lamb mixture into 4 patties. Press 1 tablespoon of the blue cheese into the center of each patty; roll into balls and then flatten into 3-by-1-inch patties. Transfer to a plate and refrigerate, uncovered, for at least 30 minutes and up to 2 hours.',
					'Heat a large cast-iron skillet over medium heat, then add the butter and canola oil. Place the cold patties in the skillet and cook until browned on both sides and cooked through, 4 to 6 minutes per side for medium-well.',
					'Assemble the burgers: Place the burgers on the buns, and layer with lettuce, red onions and tomatoes.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT55M'));
        $recipe->setUrl('http://www.cookingchanneltv.com/recipes/tia-mowry/lamb-burgers.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.cookingchanneltv.com/recipes/tia-mowry/lamb-burgers.html'
        );
        $scraper = new CookingChannelTVCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
