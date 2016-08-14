<?php

use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Scrapers\TablespoonCom;

class TablespoonComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Daring Gourmet');
        $recipe->setDescription('A BALT (bacon, avocado, lettuce, tomato) sandwich with a balsamic reduction drizzle is great for snack time or meal time.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/b1ab8df2-c235-4cd9-a577-723a5d3c2f3a.jpg');
        $recipe->setName('Bacon-Avocado-Lettuce-Tomato Snack Sandwich');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/3 cup good quality aged balsamic vinegar',
                    '4 slices bread, toasted or grilled',
                    'Mayonnaise',
                    '4 leaves lettuce',
                    '8 thick cut slices bacon, cooked',
                    '8 slices tomato',
                    '8 slices avocado',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'To make the balsamic reduction, place the balsamic vinegar in a very small saucepan and bring it to a boil. Reduce the heat to medium-low and simmer uncovered for about 15 minutes or until it is thickened and lightly coats a spoon.',
                    'To assemble the sandwiches, spread some mayonnaise on each slice of toasted bread. Next layer with lettuce, 2 slices of bacon, 2 slices of tomato and 2 slices of avocado. Drizzle with the balsamic vinegar reduction and serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT15M'));
        $recipe->setUrl('http://www.tablespoon.com/recipes/bacon-avocado-lettuce-tomato-snack-sandwich/780d10c2-77e0-441b-9f75-1bb23e2081e0');

        $crawler = $this->client->request(
            'GET',
            'http://www.tablespoon.com/recipes/bacon-avocado-lettuce-tomato-snack-sandwich/780d10c2-77e0-441b-9f75-1bb23e2081e0'
        );
        $scraper = new TablespoonCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Girl Versus Dough');
        $recipe->setDescription('Chicken salad infused with Thai flavors all rolled up in a wrap.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/9bd05126-29a4-472b-9c40-995fba397483.jpg');
        $recipe->setName('Thai Chicken Salad Wraps');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '3 chicken breasts, cut into quarters',
                    '1 1/2 cups dry cole slaw mix (shredded cabbage and carrots)',
                    '3 green onions, thinly sliced',
                    '3 tablespoons chopped cilantro',
                    '3 tablespoons chopped dry-roasted peanuts',
                    '3 tablespoons creamy peanut butter',
                    '3 tablespoons soy sauce',
                    '3 tablespoons lime juice',
                    '3 tablespoons light brown sugar',
                    '3 tablespoons light sesame oil',
                    '1 1/2 teaspoons minced garlic',
                    'Pinch of red pepper flakes',
                    '4 to 6 10-inch flour tortillas',
                    'Butter or bibb lettuce',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Bring a large pot of water to a boil. Add chicken and cook, 10-15 minutes, until fully cooked through. Remove from heat. Remove chicken from water and allow to cool completely. Cut into 1/2-inch cubes and place in a large bowl.',
                    'Add cole slaw mix, green onions, cilantro and peanuts to large bowl and toss to combine.',
                    'In a separate small bowl, whisk together peanut butter, soy sauce, lime juice, brown sugar, sesame oil, garlic and red pepper flakes until smooth. Pour sauce over dry ingredients and toss to coat completely.',
                    'Place 4-5 lettuce leaves on bottom half of each tortilla. Top each with a few heaping tablespoonfuls of chicken salad mixture. Fold over sides of tortilla, then roll up from bottom to top. Repeat with remaining tortillas. Cut tortillas in half and serve.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT30M'));
        $recipe->setUrl('http://www.tablespoon.com/recipes/thai-chicken-salad-wraps/8fe99f87-2572-40ad-942d-1c68ddc5a270');

        $crawler = $this->client->request(
            'GET',
            'http://www.tablespoon.com/recipes/thai-chicken-salad-wraps/8fe99f87-2572-40ad-942d-1c68ddc5a270'
        );
        $scraper = new TablespoonCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Hungry Happenings');
        $recipe->setDescription('If you are a fan of apple crisp à la mode, this dessert is for you.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/4ae3b03d-56ff-4488-968b-9c7afa85af6e.jpg');
        $recipe->setName('Apple Crisp Ice Cream Pie');
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cookie Crust',
                'data'  => [
                    '1 pouch Betty Crocker™ Oatmeal Cookie Mix',
                    '1 tablespoon water',
                    '1/2 cup (1 stick) butter, softened',
                    '1 large egg',
                    '1/2 teaspoon cinnamon',
                    '1/2 cup almonds, chopped',
                ],
            ],
            [
                'title' => 'Ice Cream',
                'data'  => [
                    '2 quarts vanilla ice cream',
                ],
            ],
            [
                'title' => 'Glazed Apples',
                'data'  => [
                    '4 large Granny Smith apples, peeled and cut into 1/4-inch cubes',
                    '2 tablespoons lemon juice',
                    '4 tablespoons butter, plus one more tablespoon',
                    '3/4 cup brown sugar',
                    '1 1/2 teaspoons apple pie spice',
                    '1 tablespoon all-purpose flour',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'Cookie Crust',
                'data'  => [
                    'Preheat oven to 350 °F.',
                    'Stir together the cookie mix, water, butter, egg, cinnamon and almonds.',
                    'Reserve 3/4 cup of the dough, then press the remaining dough in the bottom of a 9-inch pie pan.',
                    'Place the pie pan in the freezer for 15 minutes.',
                    'Break the remaining dough into small pieces and scatter them on a baking sheet.',
                    'Bake for 10-12 minutes until golden brown.',
                    'Remove and allow to cool completely, then crumble into small pieces.',
                    'Bake the cookie pie crust for 18-22 minutes until golden brown.',
                    'Remove and allow to cool completely.',
                    'If the crust has puffed up a lot during baking, press it down while still warm using the bottom of a glass.',
                ],
            ],
            [
                'title' => 'Ice Cream Layer',
                'data'  => [
                    'Scoop vanilla ice cream into the cooled crust.',
                    'Cover and freeze for at least 2 hours.',
                ],
            ],
            [
                'title' => 'Glazed Apples',
                'data'  => [
                    'In a skillet, melt 4 tablespoons of butter over medium heat.',
                    'Add brown sugar and stir constantly until it begins to dissolve.',
                    'Add apples and apple pie spice and toss to coat.',
                    'Continue to stir until sugar completely dissolves.',
                    'Reduce heat to medium-low and let apples simmer for 10-14 minutes, stirring occasionally until the apples are tender.',
                    'Set a fine mesh sieve over a large bowl.',
                    'Pour hot apples into sieve and allow the caramel to drain off.',
                    'Set apples aside to cool.',
                    'Return skillet to medium-low heat and add the remaining one tablespoon of butter.',
                    'Once the butter melts, stir in flour and cook for 30 seconds.',
                    'Add the caramel back into the pan and cook for 2-3 minutes until thickened.',
                    'Remove from heat, pour into a heat proof bowl and allow to cool completely.',
                ],
            ],
            [
                'title' => 'Assemble The Pie',
                'data'  => [
                    'Just before serving, spoon the apples over top of the ice cream, sprinkle on the cookie crumbles and drizzle the caramel sauce over top.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('12');
        $recipe->setTotalTime(new DateInterval('PT3H30M'));
        $recipe->setUrl('http://www.tablespoon.com/recipes/apple-crisp-ice-cream-pie/f33c04e6-8106-4300-846f-5730d9edbc9f');

        $crawler = $this->client->request(
            'GET',
            'http://www.tablespoon.com/recipes/apple-crisp-ice-cream-pie/f33c04e6-8106-4300-846f-5730d9edbc9f'
        );
        $scraper = new TablespoonCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Hungry Happenings');
        $recipe->setDescription('Want an over-the-top way to make peach cobbler that won’t take you all day to decorate? This four-layer, cinnamon-infused yellow cake topped with cheesecake filling, caramelized peaches and brown sugar cake crumbles couldn’t be more amazing.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/0374ccd2-63a9-4380-a86d-0f4acb02d607.jpg');
        $recipe->setName('Naked Peach Cobbler Cake');
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake Layers',
                'data'  => [
                    '1 box Betty Crocker™ SuperMoist™ cake mix yellow',
                    '1 cup water',
                    '1/2 cup oil',
                    '3 large eggs',
                    '1 teaspoon cinnamon',
                ],
            ],
            [
                'title' => 'Glazed Peaches',
                'data'  => [
                    '10 tablespoons butter',
                    '1/2 cup brown sugar',
                    '1/2 cup granulated sugar',
                    '10 peaches, peeled and sliced',
                    '1 teaspoon cinnamon',
                    '1/4 teaspoon nutmeg',
                ],
            ],
            [
                'title' => 'Cheesecake Layers',
                'data'  => [
                    '2 8-ounce blocks of cream cheese, softened',
                    '1/4 cup granulated sugar',
                    '7 ounces marshmallow fluff',
                    '8 ounces frozen whipped topping, thawed',
                ],
            ],
            [
                'title' => 'Brown Sugar Cake Crumbles',
                'data'  => [
                    '1/3 cup brown sugar',
                    '3/4 cup cake crumbs (from cake layers above)',
                    '1/2 teaspoon cinnamon',
                    '2 tablespoons butter, melted',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'CAKE LAYERS: Preheat oven to 350 °F. Spray two 8-inch round cake pans with baking spray, then line bottoms of pans with rounds of parchment paper. Make cake mix according to package instructions. Stir in the cinnamon and equally divide batter between cake pans. Bake for 28-34 minutes until a toothpick inserted in the center comes out clean. Remove from oven and let cool in pan for 10 minutes, then un-mold onto a cooling rack and allow to cool completely.',
                    'GLAZED PEACHES: Heat butter in a skillet set over medium-high heat. Once melted, stir in both sugars and allow to dissolve. Toss in peach slices, cinnamon and nutmeg. Bring to a boil, then reduce heat to medium-low and cook until peaches are tender, 10-16 minutes. Remove from heat and allow to cool completely.',
                    'CHEESECAKE FILLING: Beat cream cheese using an electric mixer or food processor until light and fluffy. Add sugar and marshmallow fluff and beat until well incorporated. Beat in whipped topping just until combined.',
                    'BROWN SUGAR CAKE CRUMBLES: Preheat oven to 350 °F. Cut off the domed portion of each cake and crumble the tops into very small pieces. Measure out 3/4 cup crumbs and mix with brown sugar, cinnamon and melted butter. Spread out into a thin layer on a baking sheet. Bake for 10 minutes, then remove and stir. Bake an additional 6-10 minutes until fragrant and deep golden brown. Remove and allow to cool completely.',
                    'To assemble cake: Cut each cake into 2 even layers. Set one layer on a cake plate. Spread 1/4th of the cheesecake filling over top. Spoon 1/4 of the glazed peaches on top. Sprinkle on 1/4 of the brown sugar cake crumbles over the peaches. Repeat this process, adding the remaining 3 cake layers and topping them with cheesecake filling, peaches, and cake crumbles. Refrigerate until ready to serve. Will keep in the refrigerator up to 5 days.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('12');
        $recipe->setTotalTime(new DateInterval('PT3H'));
        $recipe->setUrl('http://www.tablespoon.com/recipes/naked-peach-cobbler-cake/5155d33e-558b-4414-964c-a23518caded7');

        $crawler = $this->client->request(
            'GET',
            'http://www.tablespoon.com/recipes/naked-peach-cobbler-cake/5155d33e-558b-4414-964c-a23518caded7'
        );
        $scraper = new TablespoonCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
