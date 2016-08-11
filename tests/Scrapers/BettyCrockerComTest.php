<?php

use SSNepenthe\RecipeScraper\Scrapers\BettyCrockerCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class BettyCrockerComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Mmm! There\'s a surprise burst of creamy lemon filling inside these delicious cupcakes.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/cc01f5ab-e07f-4695-b6ba-231c8acbe219.jpg');
        $recipe->setName('Lemon Burst Cupcakes');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 box Betty Crocker™ SuperMoist™ white cake mix',
                    'Water, vegetable oil and egg whites called for on cake mix box',
                    '1 jar (10 to 12 oz) lemon curd',
                    '1 container (12 oz) Betty Crocker™ Whipped fluffy white frosting',
                    '1/4 cup Betty Crocker™ yellow candy sprinkles',
                    '1/4 cup Betty Crocker™ white candy sprinkles',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Heat oven to 350 °F (325 °F for dark or nonstick pans). Make, bake and cool cake mix as directed on box for 24 cupcakes.',
                    'By slowly spinning end of round handle of wooden spoon back and forth, make deep, 3/4-inch-wide indentation in center of top of each cupcake, not quite to bottom (wiggle end of spoon in cupcake to make opening large enough).',
                    'Spoon lemon curd into corner of resealable heavy-duty food-storage plastic bag. Cut about 1/4 inch off corner of bag. Gently push cut corner of bag into center of cupcake. Squeeze about 2 teaspoons lemon curd into center of each cupcake for filling, being careful not to split cupcake.',
                    'Frost cupcakes with frosting. To decorate, roll edge of each cupcake in candy sprinkles. Store loosely covered.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('24');
        $recipe->setTotalTime(new DateInterval('PT1H15M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964');

        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964'
        );
        $scraper = new BettyCrockerCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Make fajitas easier than ever with this oven shortcut that will save you time, but won’t skimp on flavor.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/a2634f3d-fce8-4959-904b-e2b7f13f3b85.jpg');
        $recipe->setName('Easy Oven-Baked Chicken Fajitas');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 large onion',
                    '1 medium red bell pepper',
                    '1 lb boneless skinless chicken breasts',
                    '1 package (1 oz) Old El Paso™ fajita seasoning mix',
                    '2 tablespoons vegetable oil',
                    'Old El Paso™ tortillas for soft tacos & fajitas (6 inch; from 8.2-oz package)',
                    'Sour Cream',
                    'Old El Paso™ Thick ‘n Chunky salsa',
                    'Chopped fresh cilantro',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                    'Heat oven to 400 °F. Spray 13x9-inch (3-quart) glass baking dish with cooking spray. Cut onion and bell pepper into even slices; place in baking dish.',
                    'Cut chicken breasts into thin strips; add to vegetables in dish. Sprinkle with seasoning mix; drizzle with oil. Stir until combined and pieces are coated.',
                    'Bake 35 to 40 minutes, stirring once halfway through baking, until chicken is no longer pink in center.',
                    'Spoon small amount of chicken and veggies onto each tortilla. Top each with sour cream, salsa and cilantro, or your favorite fajita toppings.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('9');
        $recipe->setTotalTime(new DateInterval('PT50M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/easy-oven-baked-chicken-fajitas/dabcc253-f43e-4b17-b92d-6b6d466ba507');

        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/easy-oven-baked-chicken-fajitas/dabcc253-f43e-4b17-b92d-6b6d466ba507'
        );
        $scraper = new BettyCrockerCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Banana, peanut butter and marshmallow make a terrific sandwich, and an even better poke cake!');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/553c4645-7aed-423e-af63-906479207968.jpg');
        $recipe->setName('Banana, Peanut Butter and Marshmallow Poke Cake');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake',
                'data'  => [
                    '1 box Betty Crocker™ SuperMoist™ yellow cake mix',
                    '1 cup mashed very ripe bananas (2 medium)',
                    '1/2 cup water',
                    '1/3 cup vegetable oil',
                    '4 eggs',
                ],
            ],
            [
                'title' => 'Filling',
                'data' => [
                    '1 box (6-serving size) vanilla instant pudding and pie filling mix',
                    '3 cups cold milk',
                    '1/3 cup creamy peanut butter',
                ],
            ],
            [
                'title' => 'Topping',
                'data' => [
                    '1 jar (7 oz) marshmallow creme',
                    '1 cup butter, softened',
                    '2 cups powdered sugar',
                    '1/3 cup creamy peanut butter',
                    'Sliced bananas',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat oven to 350 °F (325 °F for dark or nonstick pan). Grease or spray bottom only of 13x9-inch pan.',
                    'In large bowl, beat Cake ingredients with electric mixer on low speed 30 seconds, then on medium speed 2 minutes, scraping bowl occasionally. Pour into pan. Bake 26 to 33 minutes or until toothpick inserted in center comes out clean.',
                    'Remove cake from oven to cooling rack; cool 5 minutes. With handle of wooden spoon (1/4 to 1/2 inch in diameter), poke holes almost to bottom of cake every 1/2 inch, wiping spoon handle occasionally to reduce sticking.',
                    'In large bowl, beat Filling ingredients with whisk 1 minute (mixture will thicken). Pour over cake; spread evenly over surface, working back and forth to fill holes. (Some filling should remain on top of cake.) Refrigerate 1 hour.',
                    'Spoon marshmallow creme into large microwavable bowl. Microwave uncovered on High 15 to 20 seconds to soften. Add softened butter; beat with electric mixer on medium speed until smooth. Beat in powdered sugar until smooth. Spread evenly over cake.',
                    'Just before serving, in small microwavable bowl, microwave 1/3 cup peanut butter uncovered on High in 15-second intervals until thin enough to drizzle. Top cake with sliced bananas; drizzle with warm peanut butter. Cover and refrigerate any remaining cake.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('12');
        $recipe->setTotalTime(new DateInterval('PT2H10M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/banana-peanut-butter-and-marshmallow-poke-cake/5e2b9f28-7d7e-4ce2-af66-6a958d47046c');

        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/banana-peanut-butter-and-marshmallow-poke-cake/5e2b9f28-7d7e-4ce2-af66-6a958d47046c'
        );
        $scraper = new BettyCrockerCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('You\'ll fall in love with these pumpkin bars! They have a light texture, are full of cinnamon, ginger, raisins and nuts and are topped with cream cheese frosting.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/d1d62d2c-5cd2-42e2-811f-902aa914464a.jpg');
        $recipe->setName('Harvest Pumpkin-Spice Bars');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Bars',
                'data'  => [
                    '4 eggs',
                    '2 cups granulated sugar',
                    '1 cup vegetable oil',
                    '1 can (15 oz) pumpkin (not pumpkin pie mix)',
                    '2 cups Gold Medal™ all-purpose flour',
                    '2 teaspoons baking powder',
                    '2 teaspoons ground cinnamon',
                    '1 teaspoon baking soda',
                    '1/2 teaspoon salt',
                    '1/2 teaspoon ground ginger',
                    '1/4 teaspoon ground cloves',
                    '1 cup raisins, if desired',
                ],
            ],
            [
                'title' => 'Cream Cheese Frosting',
                'data' => [
                    '1 package (3 oz) cream cheese, softened',
                    '1/3 cup butter or margarine, softened',
                    '1 teaspoon vanilla',
                    '2 cups powdered sugar',
                    '1/2 cup chopped walnuts, if desired',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat oven to 350 °F. Lightly grease bottom and sides of 15x10x1-inch pan with shortening. In large bowl, beat eggs, granulated sugar, oil and pumpkin until smooth. Stir in flour, baking powder, cinnamon, baking soda, salt, ginger and cloves. Stir in raisins. Spread in pan.',
                    'Bake 25 to 30 minutes or until light brown. Cool completely in pan on cooling rack, about 2 hours.',
                    'In medium bowl, beat cream cheese, butter and vanilla with electric mixer on low speed until smooth. Gradually beat in powdered sugar, 1 cup at a time, on low speed until smooth and spreadable. Spread frosting over bars. Sprinkle with walnuts. For bars, cut into 7 rows by 7 rows. Store in refrigerator.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('49');
        $recipe->setTotalTime(new DateInterval('PT1H40M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/harvest-pumpkin-spice-bars/0ca6cc1d-4afd-452e-af7e-b931cfcb159a');

        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/harvest-pumpkin-spice-bars/0ca6cc1d-4afd-452e-af7e-b931cfcb159a'
        );
        $scraper = new BettyCrockerCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
