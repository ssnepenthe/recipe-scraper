<?php

use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Scrapers\TasteOfHomeCom;

class TasteOfHomeComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setImage('http://cdn1.tmbi.com/TOH/Images/Photos/37/1200x1200/exps39678_SD132779A06_11_1b_WEB.jpg');
        $recipe->setName('Beef & Spinach Lo Mein Recipe');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/4 cup hoisin sauce',
                    '2 tablespoons soy sauce',
                    '1 tablespoon water',
                    '2 teaspoons sesame oil',
                    '2 garlic cloves, minced',
                    '1/4 teaspoon crushed red pepper flakes',
                    '1 pound beef top round steak, thinly sliced',
                    '6 ounces uncooked spaghetti',
                    '4 teaspoons canola oil, divided',
                    '1 can (8 ounces) sliced water chestnuts, drained',
                    '2 green onions, sliced',
                    '1 package (10 ounces) fresh spinach, coarsely chopped',
                    '1 red chili pepper, seeded and thinly sliced',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                     'In a small bowl, mix the first six ingredients. Remove 1/4 cup mixture to a large bowl; add beef and toss to coat. Marinate at room temperature 10 minutes.',
                    'Cook spaghetti according to package directions. Meanwhile, in a large skillet, heat 1-1/2 teaspoons canola oil. Add half of the beef mixture; stir-fry 1-2 minutes or until no longer pink. Remove from pan. Repeat with an additional 1-1/2 teaspoons oil and remaining beef mixture.',
                    'Stir-fry water chestnuts and green onions in remaining canola oil 30 seconds. Stir in spinach and remaining hoisin mixture; cook until spinach is wilted. Return beef to pan; heat through.',
                    'Drain spaghetti; add to beef mixture and toss to combine. Sprinkle with chili pepper.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('5');
        $recipe->setTotalTime(new DateInterval('PT30M'));
        $recipe->setUrl('http://www.tasteofhome.com/recipes/beef---spinach-lo-mein');

        $crawler = $this->client->request(
            'GET',
            'http://www.tasteofhome.com/recipes/beef---spinach-lo-mein'
        );
        $scraper = new TasteOfHomeCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT20M'));
        $recipe->setImage('http://cdn1.tmbi.com/TOH/Images/Photos/37/300x300/exps108738_THHC2238741C07_28_1b.jpg');
        $recipe->setName('Mom\'s Sloppy Tacos Recipe');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1-1/2 pounds extra-lean ground beef (95% lean)',
                    '1 can (15 ounces) tomato sauce',
                    '3/4 teaspoon garlic powder',
                    '1/2 teaspoon salt',
                    '1/4 teaspoon pepper',
                    '1/4 teaspoon cayenne pepper',
                    '12 taco shells, warmed',
                    'Optional toppings: shredded lettuce and cheese, chopped tomatoes, avocado and olives',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a large skillet, cook beef over medium heat until no longer pink. Stir in the tomato sauce, garlic powder, salt, pepper and cayenne. Bring to a boil. Reduce heat; simmer, uncovered, for 10 minutes.',
                    'Fill each taco shell with 1/4 cup beef mixture and toppings of your choice.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setTotalTime(new DateInterval('PT30M'));
        $recipe->setUrl('http://www.tasteofhome.com/recipes/mom-s-sloppy-tacos');

        $crawler = $this->client->request(
            'GET',
            'http://www.tasteofhome.com/recipes/mom-s-sloppy-tacos'
        );
        $scraper = new TasteOfHomeCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setImage('http://cdn1.tmbi.com/TOH/Images/Photos/37/300x300/exps14065_TH10145C64.jpg');
        $recipe->setName('Cranberry Torte Recipe');
        $recipe->setPrepTime(new DateInterval('PT30M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1-1/4 cups graham cracker crumbs (about 20 squares)',
                    '1/4 cup finely chopped pecans',
                    '1-1/4 cups sugar, divided',
                    '6 tablespoons butter, melted',
                    '1-1/2 cups fresh or frozen cranberries',
                    '1 tablespoon thawed orange juice concentrate',
                    '1 teaspoon vanilla extract',
                    '1/8 teaspoon salt',
                    '1 cup heavy whipping cream',
                ],
            ],
            [
                'title' => 'Topping',
                'data'  => [
                    '1/2 cup sugar',
                    '1 tablespoon cornstarch',
                    '3/4 cup fresh or frozen cranberries',
                    '2/3 cup water',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a bowl, combine the cracker crumbs, pecans, 1/4 cup sugar and butter. Press onto the bottom and 1 in. up the sides of a 9-in. springform pan.',
                    'Bake at 375 ° for 8-10 minutes or until lightly browned. In a bowl, combine the cranberries, orange juice concentrate, vanilla, salt and remaining sugar.',
                    'In a bowl, beat cream until soft peaks form. Fold into the cranberry mixture. Pour into the crust. Freeze until firm.',
                    'For topping, combine sugar and cornstarch in a saucepan. Stir in cranberries and water until blended. Bring to a boil. Reduce heat; cook and stir until berries pop and mixture is thickened, about 5 minutes; cool. Let torte stand at room temperature for 10 minutes before slicing. Serve with topping.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('12-14');
        $recipe->setTotalTime(new DateInterval('PT30M'));
        $recipe->setUrl('http://www.tasteofhome.com/recipes/cranberry-torte');

        $crawler = $this->client->request(
            'GET',
            'http://www.tasteofhome.com/recipes/cranberry-torte'
        );
        $scraper = new TasteOfHomeCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT30M'));
        $recipe->setImage('http://cdn1.tmbi.com/TOH/Images/Photos/37/300x300/exps37457_THCA1693311D146.jpg');
        $recipe->setName('Chocolate Mallow Cake Recipe');
        $recipe->setPrepTime(new DateInterval('PT60M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1/3 cup shortening',
                    '1 cup sugar',
                    '1/2 cup packed brown sugar',
                    '2 large eggs',
                    '2 ounces unsweetened chocolate, melted and cooled',
                    '1 teaspoon vanilla extract',
                    '1 cup buttermilk',
                    '1/4 cup water',
                    '1-3/4 cups cake flour',
                    '1-1/2 teaspoons baking soda',
                    '3/4 teaspoon salt',
                ],
            ],
            [
                'title' => 'Filling',
                'data'  => [
                    '1 cup packed brown sugar',
                    '3 tablespoons all-purpose flour',
                    '1 cup milk',
                    '2 large egg yolks, beaten',
                    '2 tablespoons butter',
                    '1 teaspoon vanilla extract',
                    '1/2 cup chopped pecans',
                ],
            ],
            [
                'title' => 'Frosting',
                'data'  => [
                    '1-1/2 cups sugar',
                    '2 large egg whites',
                    '1/3 cup water',
                    '1 tablespoon light corn syrup',
                    '1/4 teaspoon cream of tartar',
                    '2 cups miniature marshmallows',
                    '1 ounce unsweetened chocolate, melted',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a large bowl, cream shortening and sugars. Add eggs, one at a time, beating well after each. Beat in chocolate and vanilla. Combine buttermilk and water. Combine the cake flour, baking soda and salt; add to creamed mixture alternately with buttermilk mixture.',
                    'Pour into a greased and floured 13-in. x 9-in. baking pan. Bake at 350 ° for 30-35 minutes or until a toothpick inserted near the center comes out clean. Cool for 10 minutes before removing from pan to a wire rack.',
                    'For filling, in a small saucepan, combine brown sugar and all-purpose flour. Stir in milk until smooth. Cook and stir over medium-high heat until thickened and bubbly. Reduce heat; cook and stir 2 minutes longer. Remove from the heat. Stir a small amount of hot filling into egg yolks; return all to pan, stirring constantly. Bring to a gentle boil; cook and stir 2 minutes longer.',
                    'Remove from the heat. Gently stir in butter and vanilla. Cool to room temperature without stirring. Spread over cake to within 1/2 in. of edges; sprinkle with pecans. Refrigerate for 30 minutes or until set.',
                    'For frosting, in a heavy saucepan over low heat, combine the sugar, egg whites, water, corn syrup and cream of tartar. With a portable mixer, beat on low speed for 1 minute. Continue beating on low over low heat for 8-10 minutes or until frosting reaches 160 °.',
                    'Pour into the large bowl of a heavy-duty stand mixer; add marshmallows. Beat on high for 7-9 minutes or until stiff peaks form. Carefully spread over cake. Pipe thin lines of melted chocolate over cake; gently pull a toothpick or sharp knife through lines in alternating directions. Store in the refrigerator.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('15');
        $recipe->setTotalTime(new DateInterval('PT90M'));
        $recipe->setUrl('http://www.tasteofhome.com/recipes/chocolate-mallow-cake');

        $crawler = $this->client->request(
            'GET',
            'http://www.tasteofhome.com/recipes/chocolate-mallow-cake'
        );
        $scraper = new TasteOfHomeCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
