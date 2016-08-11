<?php

use SSNepenthe\RecipeScraper\Scrapers\CookingChannelTVCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class CookingChannelTVComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
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

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Tiffani Thiessen');
        $recipe->setImage('http://cook.sndimg.com/content/dam/images/cook/fullset/2015/3/6/0/CCTIF110_Plum-Caprese-Salad-recipe_s4x3.jpg/jcr:content/renditions/cq5dam.web.266.200.jpeg');
        $recipe->setName('Plum Caprese Salad');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 tablespoon champagne vinegar',
                    '1 teaspoon white balsamic vinegar',
                    'Kosher salt and freshly ground black pepper',
                    '3 tablespoons olive oil',
                    '1 1/2 pounds heirloom tomatoes, various colors, cut into wedges',
                    '3 ripe plums, cut into wedges',
                    '8 ounces burrata cheese',
                    '1/4 cup fresh basil leaves, thinly sliced',
                    '10 fresh mint leaves, thinly sliced',
                    'Sea salt flakes, for garnishing',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Whisk together the champagne vinegar, white balsamic vinegar and a pinch of kosher salt. Stream the olive oil into the vinegar mixture, whisking; set aside. Arrange the tomatoes and plums on a serving platter, alternating the tomatoes and plums. Tear the buratta over the top. Sprinkle the basil and mint over the salad and then drizzle with the vinaigrette. Finish with a pinch of sea salt and some pepper; serve.'
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setTotalTime(new DateInterval('PT10M'));
        $recipe->setUrl('http://www.cookingchanneltv.com/recipes/tiffani-thiessen/plum-caprese-salad.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.cookingchanneltv.com/recipes/tiffani-thiessen/plum-caprese-salad.html'
        );
        $scraper = new CookingChannelTVCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT12M'));
        $recipe->setImage('http://cook.sndimg.com/content/dam/images/cook/fullset/2012/8/8/0/71761_steak_s4x3.jpg/jcr:content/renditions/cq5dam.web.266.200.jpeg');
        $recipe->setName('Chili-Rubbed Steak Tacos');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 tablespoon chili powder',
                    '2 cloves garlic, minced',
                    '1/4 teaspoon ground cinnamon',
                    '1/4 teaspoon salt',
                    'A pinch cayenne pepper',
                    '1 1/4 pound top sirloin steaks cut 1-inch thick',
                    '12 small corn tortillas (5 to 6 inches in diameter)',
                    '3 cups shredded red cabbage',
                    '1/2 cup chopped cilantro leaves',
                    '1 lime, cut into wedges',
                    '2 cups Avocado Lime Salsa, recipe follows',
                ],
            ],
            [
                'title' => 'Avocado Lime Salsa',
                'data' => [
                    '1 large cucumber peeled, seeded and cut into chunks (about 2 cups)',
                    '2 avocados, cut into chunks',
                    '1/2 red onion, diced',
                    '2 limes, juiced (about 1/4 cup)',
                    'Salt',
                    '1/4 cup chopped cilantro leaves',
                    '2 jalapeno chiles, chopped, plus more to taste',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a small bowl stir together chili powder, garlic, cinnamon, salt and cayenne pepper. Rub spice mixture on both sides of steaks. Grill or broil steaks for 5 to 6 minutes on each side for medium rare, turning once. Remove from grill and let meat sit for 10 to 15 minutes. Carve into thin slices. Warm tortillas by placing them on the grill, for about 30 seconds, turning once. Or place 6 tortillas at a time between 2 moist paper towels and microwave for 45 seconds. Wrap in cloth napkin or place in a tortilla warmer to keep warm. Place the carved steak, warm tortillas, cabbage, cilantro, lime and Avocado Lime Salsa in serving dishes and let diners make their own tacos at the table.',
                    'Place cucumber, avocado and onion in a large bowl and add lime juice and salt. Add cilantro and chiles and toss gently. Yield: 2 cups (1 serving is 1/3 cup)',
                ],
            ],
        ]);
        $recipe->setRecipeYield('12 Tacos');
        $recipe->setTotalTime(new DateInterval('PT47M'));
        $recipe->setUrl('http://www.cookingchanneltv.com/recipes/ellie-krieger/chili-rubbed-steak-tacos.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.cookingchanneltv.com/recipes/ellie-krieger/chili-rubbed-steak-tacos.html'
        );
        $scraper = new CookingChannelTVCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT35M'));
        $recipe->setImage('http://cook.sndimg.com/content/dam/images/cook/fullset/2012/8/20/0/CCUQS206_Peanut-Butter-Pie-Fudge_s4x3.jpg/jcr:content/renditions/cq5dam.web.266.200.jpeg');
        $recipe->setName('Peanut Butter Pie Fudge');
        $recipe->setPrepTime(new DateInterval('PT45M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Pie Crust',
                'data'  => [
                    '20 cream-filled chocolate sandwich cookies',
                    '1 tablespoon butter, melted',
                ],
            ],
            [
                'title' => 'Peanut Butter Fudge',
                'data' => [
                    '1 1/2 cups confectioners\' sugar',
                    '1/2 stick butter',
                    '1 cup brown sugar',
                    '1/2 cup whipping cream (30-percent fat)',
                    '1/2 teaspoon salt',
                    '1/2 cup peanut butter',
                    '1/2 teaspoon vanilla extract',
                ],
            ],
            [
                'title' => 'Caramel',
                'data' => [
                    '1/2 cup heavy cream (36-to38-percent fat)',
                    '1/2 cup brown sugar',
                    '1/2 cup granulated sugar',
                    '1/4 cup corn syrup',
                    '1/4 cup whipping cream (30-percent fat)',
                    '1/2 stick butter',
                    '1/2 teaspoon salt',
                    '1/2 teaspoon vanilla extract',
                ],
            ],
            [
                'title' => 'Marshmallows',
                'data' => [
                    '1/3 pound large marshmallows',
                ],
            ],
            [
                'title' => 'Chocolate Fudge',
                'data' => [
                    '1 1/2 cups confectioners\' sugar',
                    '2 tablespoons butter',
                    '1 1/2 cups heavy cream (36-to38-percent fat)',
                    '1/2 cup brown sugar',
                    '1/2 teaspoon salt',
                    '4 ounces unsweetened chocolate',
                    '1/2 teaspoon vanilla extract',
                ],
            ],
            [
                'title' => 'English Toffee',
                'data' => [
                    '1/4 cup English toffee pieces',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'For the crust: Preheat the oven to 340 degrees F. Break up the cookies into small pieces and press into a 9-by-9-inch baking pan. Brush with melted butter. Bake for 11 minutes. For the peanut butter fudge: Put the confectioners\' sugar in a large mixing bowl and set aside. Melt the butter in a small saucepan over medium heat. Stir in the brown sugar, whipping cream and salt. Bring to a boil. Boil for 2 minutes and remove from the heat. Stir in the peanut butter and vanilla. Pour the mixture over the confectioners\' sugar and mix. Spoon the mixture into the cookie pie crust until it is completely covered. For the caramel: In a small saucepan, combine the heavy cream, brown sugar, granulated sugar, corn syrup, whipping cream, butter and salt. Heat over low heat until the butter is completely melted. Gradually increase the heat to medium-high and bring the mixture to a boil, stirring frequently. Reduce the heat to medium and continue to boil, while stirring, until the temperature on a candy thermometer reads 250 degrees F. Remove from the heat, stir in the vanilla and pour over the peanut butter fudge. (You can double the recipe for this layer and pour half of the caramel into a buttered dish to cut up and enjoy as caramel candies.) For the marshmallows: In a microwave-safe bowl, melt the marshmallows in the microwave for 40 seconds. Working quickly, use a spatula to spread over the caramel layer. If you take too long, the marshmallows will set up and won\'t spread nicely. For the chocolate fudge: Put the confectioners\' sugar in a large mixing bowl and set aside. Melt the butter in a small saucepan over medium heat. Stir in the cream, brown sugar and salt. Bring to a boil. Boil for 2 minutes and remove from the heat. Stir in the chocolate and vanilla until all the chocolate is melted and the mixture is smooth. Pour the mixture over the confectioners\' sugar. Beat with an electric mixer for 3 to 4 minutes until very smooth. Spread evenly over the marshmallow layer with a spatula. For the toffee: Sprinkle the toffee over the top of the chocolate fudge. To serve: You do not have to wait for the fudge to set before serving. Using a metal spatula, cut and serve in cake-like squares. This recipe was provided by a chef, restaurant or culinary professional and may have been scaled down from a bulk recipe. The Food Network Kitchens chefs have not tested this recipe, in the proportions indicated, and therefore, we cannot make any representation as to the results.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('16 4-inch squares');
        $recipe->setTotalTime(new DateInterval('PT1H20M'));
        $recipe->setUrl('http://www.cookingchanneltv.com/recipes/peanut-butter-pie-fudge.html');

        $crawler = $this->client->request(
            'GET',
            'http://www.cookingchanneltv.com/recipes/peanut-butter-pie-fudge.html'
        );
        $scraper = new CookingChannelTVCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
