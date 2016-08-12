<?php

use SSNepenthe\RecipeScraper\Scrapers\PillsburyCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class PillsburyComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('It’s a little bit enchilada, a little bit chili and a whole lot of yummy!');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/a7e5296a-dad5-4855-9b7d-44f58598b6b8.jpg');
        $recipe->setName('Slow-Cooker Cheesy Chicken Enchilada Chili');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 package (20 oz) boneless skinless chicken thighs, cut into 1-inch pieces',
                    '1 can (15.2 oz) whole kernel sweet corn, drained, rinsed',
                    '1 can (15 oz) Progresso™ black beans, drained, rinsed',
                    '1 can (10 oz) Old El Paso™ mild enchilada sauce',
                    '2 tablespoons Old El Paso™ taco seasoning mix (from 1-oz package)',
                    '2 cups shredded Colby-Monterey Jack cheese blend (8 oz)',
                    'Chopped green onions and sour cream, if desired',
                    '4 cups tortilla chips',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Spray 4-quart slow cooker with cooking spray. In slow cooker, mix chicken, corn, beans, enchilada sauce and taco seasoning mix. Cover and cook on Low heat setting 8 hours or High heat setting 4 hours.',
                    'Stir in 1 cup of the cheese. Top with green onions and sour cream. Top with remaining cheese; serve with tortilla chips.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT4H10M'));
        $recipe->setUrl('https://www.pillsbury.com/recipes/slow-cooker-cheesy-chicken-enchilada-chili/389d56ac-2840-4327-a23b-1303539a7248');

        $crawler = $this->client->request(
            'GET',
            'https://www.pillsbury.com/recipes/slow-cooker-cheesy-chicken-enchilada-chili/389d56ac-2840-4327-a23b-1303539a7248'
        );
        $scraper = new PillsburyCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('This hearty make-ahead casserole is ready to go in the oven the next morning for a great family breakfast.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/85606690-0cff-4b07-87e2-4ab2c7617ac9.jpg');
        $recipe->setName('Overnight Country Sausage and Hash Brown Casserole');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 package (16 oz) bulk hot pork sausage',
                    '10 eggs',
                    '1 1/2 cups milk',
                    '2 teaspoons Dijon mustard',
                    '1/4 teaspoon ground pepper',
                    '1 bag (20 oz) refrigerated O’Brien hash browns (about 4 1/2 cups)',
                    '1 1/2 cups shredded sharp Cheddar cheese (6 oz)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Spray 13x9-inch (3-quart) baking dish with cooking spray. In 8-inch skillet, cook sausage over medium heat 5 to 7 minutes or until no longer pink; drain.',
                    'In large bowl, beat eggs, milk, Dijon mustard and pepper with whisk until mixed well. Stir in hash browns, 1 cup of the cheese and the cooked sausage. Pour mixture in baking dish; cover and refrigerate at least 8 hours but no longer than 12 hours.',
                    'Heat oven to 350 °F. Remove dish from refrigerator, uncover and top with remaining 1/2 cup cheese. Bake 45 to 55 minutes or until center is just set. Cool 10 minutes before serving.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('8');
        $recipe->setTotalTime(new DateInterval('PT9H25M'));
        $recipe->setUrl('https://www.pillsbury.com/recipes/overnight-country-sausage-and-hash-brown-casserole/e6b3ef2a-3e5f-4db5-9684-c5b199f3482f');

        $crawler = $this->client->request(
            'GET',
            'https://www.pillsbury.com/recipes/overnight-country-sausage-and-hash-brown-casserole/e6b3ef2a-3e5f-4db5-9684-c5b199f3482f'
        );
        $scraper = new PillsburyCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Hide a luscious surprise--a thick band of semisweet chocolate--in the center of this rich cake.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/aa63d50e-cbe3-4da9-bb7f-3fcda30954eb.jpg');
        $recipe->setName('Pumpkin Truffle Pound Cake with Browned Butter Icing');
        $recipe->setPrepTime(new DateInterval('PT25M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake',
                'data'  => [
                    '2/3 cup (from 14-oz can) sweetened condensed milk (not evaporated)',
                    '1 cup semisweet chocolate chips (6 oz)',
                    '3 cups all-purpose flour',
                    '2 teaspoons baking powder',
                    '1 teaspoon baking soda',
                    '4 teaspoons pumpkin pie spice',
                    '1/4 teaspoon salt',
                    '1 1/2 cups butter or margarine, softened',
                    '1 cup granulated sugar',
                    '1/2 cup packed brown sugar',
                    '6 eggs',
                    '1 cup canned pumpkin (not pumpkin pie mix)',
                ],
            ],
            [
                'title' => 'Icing',
                'data'  => [
                    '1/4 cup butter (do not use margarine)',
                    '1 cup powdered sugar',
                    '1 teaspoon vanilla',
                    '1 to 2 tablespoons milk',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat oven to 350 °F. Grease 12-cup fluted tube cake pan with shortening; lightly flour (or spray with baking spray with flour). In 1-quart saucepan, heat condensed milk and chocolate chips over medium-low heat, stirring occasionally, until chocolate is melted. Remove from heat; set aside.',
                    'In medium bowl, mix flour, baking powder, baking soda, pumpkin pie spice and salt until blended; set aside.',
                    'In large bowl, beat 1 1/2 cups butter, the granulated sugar and brown sugar with electric mixer on medium speed about 2 minutes or until well blended. Add eggs, one at a time, beating well after each addition. On low speed, beat in flour mixture in 3 additions alternately with pumpkin until well blended (batter will be thick).',
                    'Spoon 2/3 of batter (about 5 cups) into pan, bringing batter up about 1 inch on tube and on outside edge of pan. Stir chocolate mixture; spoon into center of batter, being careful not to touch sides of pan. Spoon remaining cake batter (about 2 cups) over filling; smooth top.',
                    'Bake 55 to 65 minutes or until toothpick inserted in center of cake comes out clean and center of crack is dry to touch. Cool cake in pan 15 minutes. Remove from pan to cooling rack. Cool completely, about 1 hour.',
                    'Place cooled cake on serving plate. In 1-quart saucepan, heat 1/4 cup butter over medium heat, stirring occasionally, until golden brown. Pour browned butter into medium bowl; stir in powdered sugar, vanilla and milk, 1 tablespoon at a time, until spreadable (mixture will thicken as it cools). Let stand 1 to 2 minutes or until slightly cool; stir. Drizzle over cake.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('16');
        $recipe->setTotalTime(new DateInterval('PT2H45M'));
        $recipe->setUrl('http://www.bettycrocker.com/recipes/pumpkin-truffle-pound-cake-with-browned-butter-icing/286ccef8-aea2-4c09-971e-b8d4721be0dc');

        $crawler = $this->client->request(
            'GET',
            'https://www.pillsbury.com/recipes/pumpkin-truffle-pound-cake-with-browned-butter-icing/d75a96af-a865-4450-9224-a758f3b74173'
        );
        $scraper = new PillsburyCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Enjoy this yummy red colored cake layered with frosting--a delicious dessert treat.');
        $recipe->setImage('http://images-gmi-pmc.edge-generalmills.com/00f6aa66-61c7-4245-b020-af313d1ad08a.jpg');
        $recipe->setName('Quick Red Velvet Cake');
        $recipe->setPrepTime(new DateInterval('PT40M'));
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake',
                'data'  => [
                    '1 box chocolate cake mix',
                    '1 cup water',
                    '1/2 cup sour cream',
                    '1/4 cup vegetable oil',
                    '3 eggs',
                    '2 tablespoons unsweetened baking cocoa',
                    '1 bottle (1 oz) red food color',
                ],
            ],
            [
                'title' => 'Frosting',
                'data'  => [
                    '1/2 cup all-purpose flour',
                    '1 1/2 cups milk',
                    '1 1/2 cups sugar',
                    '1 1/2 cups butter or margarine, softened',
                    '1 tablespoon vanilla',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat oven to 350 °F (325 °F for dark or nonstick pans). Grease and flour two 9-inch cake pans, or spray with baking spray with flour. In large bowl, beat cake ingredients with electric mixer on low speed 30 seconds, then on medium speed 2 minutes, scraping bowl occasionally. Pour batter into pans.',
                    'Bake 31 to 36 minutes or until toothpick inserted in center comes out clean. Cool 10 minutes; remove from pans to cooling rack. Cool completely.',
                    'Meanwhile, in 2-quart saucepan, cook flour and milk over medium heat, stirring constantly, until mixture is very thick. Cover surface with plastic wrap; cool to room temperature.',
                    'In large bowl, beat sugar and butter with electric mixer on high speed until light and fluffy. Gradually add flour mixture by tablespoonfuls, beating until smooth. Beat in vanilla.',
                    'Place 1 cake layer, top side down, on serving plate; spread with 1 cup frosting. Top with second layer, top side up. Frost side and top of cake with frosting. Store in refrigerator.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('16');
        $recipe->setTotalTime(new DateInterval('PT2H45M'));
        $recipe->setUrl('https://www.pillsbury.com/recipes/quick-red-velvet-cake/d6859094-96b1-4ef9-b1ac-c21990234b82');

        $crawler = $this->client->request(
            'GET',
            'https://www.pillsbury.com/recipes/quick-red-velvet-cake/d6859094-96b1-4ef9-b1ac-c21990234b82'
        );
        $scraper = new PillsburyCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
