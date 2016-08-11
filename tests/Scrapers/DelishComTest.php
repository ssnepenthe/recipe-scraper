<?php

use SSNepenthe\RecipeScraper\Scrapers\DelishCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class DelishComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Nancy Dell\'Aria');
        $recipe->setDescription('Fish can get predictable pretty easily, so liven things up with this creamy chowder featuring cod with corn, bacon and a mix of cubed red potatoes, onions, carrots and celery sautéed in bacon fat.');
        $recipe->setImage('http://del.h-cdn.co/assets/cm/15/10/54f8dc103b330_-_fish-veggie-chowder-lg.jpg');
        $recipe->setName('Fish and Veggie Chowder');
        $recipe->setPrepTime(new DateInterval('PT40M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '4 slice bacon',
                    '2 carrots',
                    '2 stalk celery',
                    '1 large onion',
                    'Kosher salt and pepper',
                    '3 tbsp. all-purpose flour',
                    '3 c. whole milk',
                    '1 lb. red potatoes',
                    '1 1/2 tsp. Old Bay seasoning',
                    '1 c. corn kernels',
                    '3/4 lb. skinless firm white fish (such as, cod, haddock or hake)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Cook the bacon in a large saucepan or Dutch oven over medium heat until crisp, 5 to 6 minutes. Transfer to a paper towel-lined plate. Discard all but 1 Tbsp fat from the pan.',
                    'Add the carrot, celery, onion and 1/2 tsp each salt and pepper to the pan and cook, covered, stirring occasionally, for 5 minutes. Sprinkle the flour over the vegetable mixture and cook, stirring, for 1 minute. Whisk in the milk and 2 cups water and bring to a boil.',
                    'Add the potatoes and Old Bay, reduce heat and simmer until the potatoes are just tender, 12 to 15 minutes. Stir in the corn and fish and simmer until the fish is opaque throughout, 3 to 5 minutes. Break the bacon into pieces and sprinkle over the soup.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT40M'));
        $recipe->setUrl('http://www.womansday.com/food-recipes/food-drinks/recipes/a10509/fish-veggie-chowder-121971/');

        $crawler = $this->client->request(
            'GET',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a33641/fish-veggie-chowder-121971/'
        );
        $scraper = new DelishCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Judy Kim');
        $recipe->setDescription('Ditch the deli meat and spring for juicy steak.');
        $recipe->setImage('http://del.h-cdn.co/assets/16/31/1600x800/landscape-1470330385-chimichurri-steak-sandwichp2.jpg');
        $recipe->setName('Chimichurri Steak Sandwich');
        $recipe->setPrepTime(new DateInterval('PT5M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1/2 c. fresh cilantro',
                    '3/4 c. fresh basail',
                    '1/2 c. Chopped red onion',
                    '3 garlic cloves, chopped',
                    'kosher salt',
                    '1/2 tsp. crushed red pepper flakes',
                    '3 tbsp. red wine vinegar',
                    'extra-virgin olive oil',
                    '1 lb. skirt steak',
                    'Freshly ground black pepper',
                    '1 loaf country bread, sliced 1/2" thick',
                    '2 large heirloom tomatoes, sliced 1/4" thick',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'In the bowl of a food processor add cilantro, 1/2 cup basil, red onion, garlic, 1 teaspoon salt, red pepper flakes, and vinegar. Pulse a few times and scrape down sides of the bowl. While motor is running, drizzle in olive oil and process until almost smooth, but leave some texture. Set aside.',
                    'Preheat grill on medium-high heat. Drizzle steak with olive oil and season with salt and pepper. Place on grill and cook until lightly charred, about 3 minutes on each side. Transfer to a clean plate and loosely tent with foil; let the meat rest.',
                    'Meanwhile, toast bread on grill until slightly charred. Slice steak thinly on diagonal against the grain.',
                    'Spread chimichurri on toasted bread. Layer sliced steak with tomatoes and a few basil leaves. Top with toasted bread to close the sandwich.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT20M'));
        $recipe->setUrl('http://www.delish.com/cooking/recipe-ideas/recipes/a48545/chimichurri-steak-sandwich-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a48545/chimichurri-steak-sandwich-recipe/'
        );
        $scraper = new DelishCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Candace Braun Davison');
        $recipe->setCookTime(new DateInterval('PT12M'));
        $recipe->setDescription('It\'s a whole new take on the fudgy dessert that set Pinterest on fire.');
        $recipe->setImage('http://del.h-cdn.co/assets/15/46/1447456786-delish-cool-whip-pies-slutty-brownie-recipe.jpg');
        $recipe->setName('Slutty Brownie Pie');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Chocolate Chip Cookie Crust',
                'data' => [
                    '1 tube premade chocolate chip cookie dough',
                ],
            ],
            [
                'title' => 'Pudding Layer',
                'data' => [
                    '2/3 packet instant chocolate pudding mix',
                    '1 1/2 c. milk',
                ],
            ],
            [
                'title' => 'Chocolate Whipped Cream Layer',
                'data' => [
                    '1 container cool whip',
                    '1/3 packet instant chocolate pudding mix',
                    '1/2 c. crumbled brownie pieces',
                    'chocolate sauce',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'For the crust: Preheat the oven to 350 °F. As it heats, grease the bottom and sides of a 9-inch pie plate. Cover with chocolate chip cookie dough. Bake for 16-18 minutes, and shortly after it\'s out of the oven, use a measuring cup to press down the dough so it forms a gooey crust. Place in the refrigerator to cool.',
                    'For the pudding layer: Whisk 2/3 packet of pudding mix with milk. Refrigerate five minutes to set, then pour into the cooled cookie crust. Cover the pudding with a layer of Oreo cookies.',
                    'For the chocolate whipped cream layer: In a separate bowl, mix Cool Whip with remaining 1/3 packet pudding mix. Fold in crumbled brownies, and pour the mixture on top of the pie. Garnish with more brownie pieces. Refrigerate for 4 hours, then drizzle with chocolate sauce just before serving.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('8');
        $recipe->setTotalTime(new DateInterval('PT27M'));
        $recipe->setUrl('http://www.delish.com/cooking/recipe-ideas/recipes/a44836/slutty-brownie-pie-recipe-cool-whip-desserts/');

        $crawler = $this->client->request(
            'GET',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a44836/slutty-brownie-pie-recipe-cool-whip-desserts/'
        );
        $scraper = new DelishCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Lauren Salkeld');
        $recipe->setDescription('With a fudgy brownie bottom and rich layer of pumpkin cheesecake, these bars are on the must-make list for fall.');
        $recipe->setImage('http://del.h-cdn.co/assets/15/43/1600x800/landscape-1445292205-pumpkin-cheesecake-bars-1.jpg');
        $recipe->setName('Pumpkin Cheesecake Brownie Bars');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Brownies',
                'data' => [
                    '1 c. (2 sticks) unsalted butter',
                    '8 oz. semisweet chocolate, coarsely chopped',
                    '2 c. sugar',
                    '4 large eggs',
                    '1 tbsp. pure vanilla extract',
                    '1 1/4 c. all-purpose flour',
                    '1 tsp. baking powder',
                    '1/2 tsp. kosher salt',
                    '1/2 c. chocolate chips',
                ],
            ],
            [
                'title' => 'For The Cheesecake',
                'data' => [
                    '2 8-ounce packages cream cheese, at room temperature',
                    '3/4 c. sugar',
                    '1 1/2 tsp. pumpkin pie spice',
                    '1/8 tsp. kosher salt',
                    '2 tsp. pure vanilla extract',
                    '1 c. canned pumpkin',
                    '1/4 c. heavy cream',
                    '1/4 c. sour cream',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Make the brownies: Butter a 9-x-13" baking pan and line with parchment paper, leaving a 2" overhang on all sides. Butter the parchment. Set a rack in the middle of the oven and preheat to 350 degrees F.',
                    'In a bowl set over a pan of barely simmering water, melt chocolate and butter, stirring until smooth. Set aside to cool.',
                    'In a medium bowl, whisk together sugar, eggs, and vanilla. In a second medium bowl, whisk together flour, baking powder, and salt. Add sugar mixture to melted chocolate and whisk to combine. Add flour mixture and chocolate chips and gently fold until just combined and streak free.',
                    'Pour brownie batter into prepared baking pan and smooth top. Bake until just set, 12 to 15 minutes. Let cool on a wire rack. Reduce oven temperature to 325 degrees F.',
                    'Make the cheesecake: In the bowl of a stand mixer fitted with the paddle attachment (or a large bowl with a hand mixer), beat cream cheese on medium speed, scraping down bowl as necessary, until completely smooth, 3 to 4 minutes. Add pumpkin pie spice and salt and beat, scraping down bowl as necessary, until smooth and fluffy, 3 to 4 minutes. Add vanilla and beat 30 seconds. Add eggs one at a time, beating 1 minute after each addition and scraping down bowl as necessary. Add pumpkin, heavy cream, and sour cream and beat on low until completely smooth and streak-free, about 1 minute.',
                    'Pour cheesecake batter over cooled brownies and smooth top. Bake until set around the edges and just barely jiggling in the center, 45 minutes. Let cheesecake cool to room temperature on a wire rack. Once completely cool, loosely cover cheesecake with plastic wrap and chill in the refrigerator at least 3 hours, but preferably overnight.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('24 bars');
        $recipe->setTotalTime(new DateInterval('PT6H15M'));
        $recipe->setUrl('http://www.delish.com/cooking/recipe-ideas/recipes/a44395/pumpkin-cheesecake-brownie-bars-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a44395/pumpkin-cheesecake-brownie-bars-recipe/'
        );
        $scraper = new DelishCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
