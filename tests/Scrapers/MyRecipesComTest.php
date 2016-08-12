<?php

use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Scrapers\MyRecipesCom;

class MyRecipesComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Melanie Barnard');
        $recipe->setDescription('Flour tortillas stand in for the traditional biscuit dough so you can bring this crowd-pleaser from stove to table in minutes.');
        $recipe->setImage('http://cdn-image.myrecipes.com/sites/default/files/styles/300x300/public/quick-chicken-dumplings-mr.jpg?itok=7iuasoNn');
        $recipe->setName('Quick Chicken and Dumplings');
        $recipe->setPublisher('Cooking Light');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 tablespoon butter',
                    '1/2 cup prechopped onion',
                    '2 cups chopped roasted skinless, boneless chicken breasts',
                    '1 (10-ounce) box frozen mixed vegetables, thawed',
                    '1 1/2 cups water',
                    '1 tablespoon all-purpose flour',
                    '1 (14-ounce) can fat-free, less-sodium chicken broth',
                    '1/4 teaspoon salt',
                    '1/4 teaspoon black pepper',
                    '1 bay leaf',
                    '8 (6-inch) flour tortillas, cut into 1/2-inch strips',
                    '1 tablespoon chopped fresh parsley',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Melt butter in a large saucepan over medium-high heat. Add onion; sauté 5 minutes or until tender. Stir in chicken and vegetables; cook 3 minutes or until thoroughly heated, stirring constantly.',
                    'While chicken mixture cooks, combine water, flour, and broth. Gradually stir broth mixture into chicken mixture. Stir in salt, pepper, and bay leaf; bring to a boil. Reduce heat, and simmer 3 minutes. Stir in tortilla strips, and cook 2 minutes or until tortilla strips soften. Remove from heat; stir in parsley. Discard bay leaf. Serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.myrecipes.com/recipe/quick-chicken-dumplings-0');

        $crawler = $this->client->request(
            'GET',
            'http://www.myrecipes.com/recipe/quick-chicken-dumplings-0'
        );
        $scraper = new MyRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Deb Wise');
        $recipe->setDescription('The creamy sauce offers a cool counterpoint to the bold blackening spices. Not in the mood for tilapia? The recipe is also great with chicken, sliced flank steak, or shrimp. Toss some avocado, tomato, and cilantro into the mix, and you\'re ready to knock Taco Tuesday out of the park.');
        $recipe->setImage('http://cdn-image.myrecipes.com/sites/default/files/styles/300x300/public/6037701_aug16_superfast8691.jpg?itok=ojhkbq9d');
        $recipe->setName('Fish Tacos with Sweet Pickle Sauce');
        $recipe->setPublisher('Cooking Light');
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    'Cooking spray',
                    '4 (5-oz.) tilapia fillets',
                    '1 teaspoon chili powder',
                    '5/8 teaspoon kosher salt, divided',
                    '1/2 teaspoon freshly ground black pepper, divided',
                    '1/2 teaspoon ground red pepper',
                    '1/2 teaspoon ground cumin',
                    '3 tablespoons canola mayonnaise',
                    '2 tablespoons sweet pickle relish',
                    '8 (6-in.) corn tortillas',
                    '1 ripe avocado, cut into 8 wedges',
                    '1 medium tomato, cut into 16 wedges',
                    '1/2 cup cilantro leaves',
                    '1 lime, cut into wedges',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat a grill pan over medium-high. Coat pan with cooking spray.',
                    'Sprinkle fish evenly with chili powder, 3/8 teaspoon salt, 1/4 teaspoon black pepper, red pepper, and cumin. Add fish to pan; cook 3 minutes on each side or until fish flakes easily when tested with a fork. Cut each fillet into slices.',
                    'Combine mayonnaise, pickle relish, remaining 1/4 teaspoon salt, and 1/4 teaspoon black pepper in a small bowl. Heat tortillas according to package directions.',
                    'Divide fish, avocado, and tomato evenly among tortillas. Drizzle tacos evenly with mayonnaise mixture; sprinkle with cilantro. Serve with lime wedges.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.myrecipes.com/recipe/fish-tacos-sweet-pickle-sauce');

        $crawler = $this->client->request(
            'GET',
            'http://www.myrecipes.com/recipe/fish-tacos-sweet-pickle-sauce'
        );
        $scraper = new MyRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Bill and Cheryl Jamison');
        $recipe->setDescription('If you\'ve never eaten slaw on rather than with a sandwich, you\'re in for a treat. You\'ll need to start the pork and soak the wood chunks a day ahead; you can make the mustard-laced slaw a day in advance as well. If you\'d rather not have sandwiches, serve the meat as is or use it to flavor baked beans.');
        $recipe->setImage('http://cdn-image.myrecipes.com/sites/default/files/styles/300x300/public/image/recipes/ck/pork-sandwich-ck-1634713-x.jpg?itok=kmuwg0dt');
        $recipe->setName('Memphis Pork and Coleslaw Sandwich');
        $recipe->setPublisher('Cooking Light');
        $recipe->setRecipeIngredients([
            [
                'title' => 'Pork',
                'data'  => [
                    '8 hickory wood chunks (about 4 pounds)',
                    '2 tablespoons paprika',
                    '1 tablespoon freshly ground black pepper',
                    '1 tablespoon turbinado sugar',
                    '1 1/2 teaspoons kosher salt',
                    '1 1/2 teaspoons garlic powder',
                    '1 1/2 teaspoons onion powder',
                    '1 1/2 teaspoons dry mustard',
                    '1 (5-pound) bone-in pork shoulder (Boston butt)',
                    '1/3 cup white vinegar',
                    '1 tablespoon Worcestershire sauce',
                    '1 teaspoon canola oil',
                    '1 (12-ounce) can beer',
                    '2 cups water',
                    'Cooking spray',
                ],
            ],
            [
                'title' => 'Slaw',
                'data'  => [
                    '1/4 cup finely chopped onion',
                    '1 1/2 tablespoons prepared mustard',
                    '1 1/2 tablespoons white vinegar',
                    '1 tablespoon reduced-fat mayonnaise',
                    '1 1/2 teaspoons granulated sugar',
                    '1/4 teaspoon salt',
                    '6 cups chopped green cabbage',
                ],
            ],
            [
                'title' => 'Remaining Ingredients',
                'data'  => [
                    '13 hamburger buns',
                    '1 2/3 cups Memphis Barbecue Sauce',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'To prepare pork, soak wood chunks in water about 16 hours; drain.',
                    'Combine paprika and next 6 ingredients (through dry mustard); reserve 1 tablespoon paprika mixture. Rub half of remaining paprika mixture onto pork. Place in a large zip-top plastic bag; seal and refrigerate overnight.',
                    'Remove pork from refrigerator; let stand at room temperature 30 minutes. Rub remaining half of paprika mixture onto pork.',
                    'Combine reserved 1 tablespoon paprika mixture, 1/3 cup vinegar, Worcestershire, oil, and beer in a small saucepan; cook over low heat 5 minutes or until warm.',
                    'Remove grill rack; set aside. Prepare grill for indirect grilling, heating one side to medium-low and leaving one side with no heat. Maintain temperature at 225 °. Pierce bottom of a disposable aluminum foil pan several times with the tip of a knife. Place pan on heated side of grill; add half of wood chunks to pan. Place another disposable aluminum foil pan (do not pierce pan) on unheated side of grill. Pour 2 cups water in pan. Coat grill rack with cooking spray; place grill rack on grill.',
                    'Place pork on grill rack over foil pan on unheated side. Close lid; cook 4 1/2 hours or until a thermometer registers 170 °, gently brushing pork with beer mixture every hour (avoid brushing off sugar mixture). Add additional wood chunks halfway during cooking time. Discard any remaining beer mixture.',
                    'Preheat oven to 250 °.',
                    'Remove pork from grill. Wrap pork in several layers of aluminum foil, and place in a baking pan. Bake at 250 ° for 2 hours or until a thermometer registers 195 °. Remove from oven. Let stand, still wrapped, 1 hour or until pork easily pulls apart. Unwrap pork; trim and discard fat. Shred pork with 2 forks.',
                    'While pork bakes, prepare slaw. Combine onion and next 5 ingredients (through 1/4 teaspoon salt) in a large bowl. Add cabbage, and toss to coat. Cover and chill 3 hours before serving. Serve pork and slaw on buns with Memphis Barbecue Sauce.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('13');
        $recipe->setUrl('http://www.myrecipes.com/recipe/memphis-pork-coleslaw-sandwich');

        $crawler = $this->client->request(
            'GET',
            'http://www.myrecipes.com/recipe/memphis-pork-coleslaw-sandwich'
        );
        $scraper = new MyRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Ann Taylor Pittman');
        $recipe->setDescription('Thawed lemonade concentrate adds bold, fun flavor to this tart layer cake. This cake is the perfect solution to summer birthday parties or winter events when you need to wake up your taste buds.');
        $recipe->setImage('http://cdn-image.myrecipes.com/sites/default/files/styles/300x300/public/image/recipes/ck/02/04/layer-cake-ck-249959-x.jpg?itok=1Ma3bcrJ');
        $recipe->setName('Lemonade Layer Cake');
        $recipe->setPublisher('Cooking Light');
        $recipe->setRecipeIngredients([
            [
                'title' => 'Cake',
                'data'  => [
                    '1 1/3 cups granulated sugar',
                    '6 tablespoons butter, softened',
                    '1 tablespoon grated lemon rind',
                    '3 tablespoons thawed lemonade concentrate',
                    '2 teaspoons vanilla extract',
                    '2 large eggs',
                    '2 large egg whites',
                    '2 cups all-purpose flour',
                    '1 teaspoon baking powder',
                    '1/2 teaspoon salt',
                    '1/2 teaspoon baking soda',
                    '1 1/4 cups fat-free buttermilk',
                    'Cooking spray',
                ],
            ],
            [
                'title' => 'Frosting',
                'data'  => [
                    '2 tablespoons butter, softened',
                    '2 teaspoons grated lemon rind',
                    '2 teaspoons thawed lemonade concentrate',
                    '1/2 teaspoon vanilla extract',
                    '8 ounces 1/3-less-fat cream cheese',
                    '3 1/2 cups powdered sugar',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat oven to 350 °.',
                    'To prepare cake, place first 5 ingredients in a large bowl; beat with a mixer at medium speed until well blended (about 5 minutes). Add eggs and egg whites, 1 at a time, beating well after each addition. Lightly spoon flour into dry measuring cups; level with a knife. Combine flour, baking powder, salt, and baking soda; stir well with a whisk. Add flour mixture and buttermilk alternately to sugar mixture, beginning and ending with flour mixture; beat well after each addition.',
                    'Pour batter into 2 (9-inch) round cake pans coated with cooking spray; sharply tap pans once on counter to remove air bubbles. Bake at 350 ° for 20 minutes or until wooden pick inserted in center comes out clean. Cool in pans 10 minutes on a wire rack; remove from pans. Cool completely on wire rack.',
                    'To prepare frosting, place 2 tablespoons butter and the next 4 ingredients (2 tablespoons butter through cream cheese) in a large bowl; beat with a mixer at high speed until fluffy. Add powdered sugar, and beat at low speed just until blended (do not overbeat). Chill 1 hour.',
                    'Place 1 cake layer on a plate; spread with 1/2 cup frosting. Top with remaining cake layer. Spread remaining frosting over top and sides of cake. Store cake loosely covered in the refrigerator.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('16');
        $recipe->setUrl('http://www.myrecipes.com/recipe/lemonade-layer-cake');

        $crawler = $this->client->request(
            'GET',
            'http://www.myrecipes.com/recipe/lemonade-layer-cake'
        );
        $scraper = new MyRecipesCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
