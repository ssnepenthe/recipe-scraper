<?php

use SSNepenthe\RecipeScraper\Scrapers\JustATasteCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class JustATasteComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kelly Senyei');
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setDescription('All you need is 30 minutes and a few simple ingredients for a quick and easy Spanish tortilla recipe paired with a refreshing tomato salad.');
        $recipe->setImage('http://www.justataste.com/wp-content/uploads/2016/05/spanish-tortilla-recipe.jpg');
        $recipe->setName('Spanish Tortilla with Tomato Salad');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeCategories([
            '30-Minute Meals',
            'Entrées',
            'Recipes',
            'Salads',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '3 medium russet potatoes',
                    '4 Tablespoons olive oil, divided',
                    '3/4 cup diced yellow onions',
                    '5 large eggs',
                    '1/4 cup heavy cream',
                    '2 large tomatoes, diced',
                    '1/2 cup loosely packed parsley leaves',
                    '3 Tablespoons red wine vinegar',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Peel then cut the potatoes into 1/8-inch-thick slices using a sharp knife or mandoline.',
                    'Add 2 tablespoons olive oil to a large non-stick sauté pan set over low heat. Add the sliced potatoes, diced onions and a pinch of salt. Cover the pan and cook, stirring occasionally, until the potatoes have softened, about 10 minutes. Drain any excess oil from the pan then transfer the mixture to a large bowl.',
                    'In a separate medium bowl, whisk together the eggs and heavy cream with a pinch of salt and black pepper. Pour the egg mixture over the potatoes and fold it carefully to combine without breaking apart the potatoes.',
                    'Add 1 tablespoon olive oil to a non-stick sauté pan set over medium heat. Add the potato mixture to the pan and using a spatula, gently lift the mixture so the uncooked eggs flow underneath. Spread the mixture into an even layer, reduce the heat to low and cook the tortilla, occasionally releasing the edges with a spatula. Once the eggs are mostly set, place a plate atop the pan then invert the pan to flip the tortilla onto the plate. Return the tortilla to the pan (uncooked side down) and continue cooking until the eggs are fully set.',
                    'Slide the cooked tortilla onto a serving plate.',
                    'In a small bowl, combine the diced tomatoes and parsley leaves. Toss the salad with the remaining 1 tablespoon olive oil, red wine vinegar, and a pinch of salt and pepper. Pile the salad atop the tortilla, slice and serve.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6');
        $recipe->setUrl('http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/'
        );
        $scraper = new JustATasteCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kelly Senyei');
        $recipe->setCookTime(new DateInterval('PT55M'));
        $recipe->setDescription('Stuck with overripe bananas? Don\'t miss this quick and easy recipe for mixed berry banana bread loaded with fresh fruit!');
        $recipe->setImage('http://www.justataste.com/wp-content/uploads/2016/06/mixed-berry-banana-bread-image-580x875.jpg');
        $recipe->setName('Mixed Berry Banana Bread');
        $recipe->setPrepTime(new DateInterval('PT10M'));
        $recipe->setRecipeCategories([
            'Bread',
            'Breakfast & Brunch',
            'Recipes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 cups all-purpose flour',
                    '3/4 cup sugar',
                    '1 teaspoon baking soda',
                    '1/2 teaspoon salt',
                    '3 very ripe, darkly speckled large bananas, mashed well (about 1 1/2 cups)',
                    '1/4 cup buttermilk',
                    '2 large eggs, lightly beaten',
                    '1/4 cup vegetable oil',
                    '2 teaspoons vanilla extract',
                    '1 cup mixed berries, such as raspberries, blueberries or blackberries',
                    'Sanding sugar, for topping (optional)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat the oven to 350 °F. Line a 9-inch loaf pan with parchment then grease the parchment with cooking spray.',
                    'In a medium bowl, whisk together the flour, sugar, baking soda and salt. Set the mixture aside.',
                    'In a separate medium bowl, stir together the mashed bananas, buttermilk, eggs, vegetable oil and vanilla extract.',
                    'Lightly stir the banana mixture into the dry ingredients with a rubber spatula just the batter looks thick and chunky. Add the berries and fold just until combined then scrape batter into the prepared loaf pan.',
                    'Sprinkle the top of the batter with a generous amount of sanding sugar (optional) then bake the bread for 55 minutes or until a toothpick inserted comes out clean.',
                    'Allow the loaf to cool in the pan for 5 minutes then transfer it to a cooling rack to cool completely. Slice and serve.',
                ],
            ],
            [
                'title' => 'Kelly\'s Notes',
                'data'  => [
                    'Extra-ripe bananas are the key to the most moist, flavorful banana bread. Don\'t be afraid to let bananas turn completely brown before using them for banana bread.',
                    'If you don\'t have buttermilk on hand, you can make a quick version using whole milk and lemon juice or white vinegar. Add 1 tablespoon of lemon juice or white vinegar to a liquid measuring cup, and then pour in the milk until it reaches the 1-cup mark. Let the mixture sit for 5 minutes, then use 1/4 cup for this recipe and save the rest for another use.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('1 (9-inch) loaf');
        $recipe->setUrl('http://www.justataste.com/mixed-berry-banana-bread-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/mixed-berry-banana-bread-recipe/'
        );
        $scraper = new JustATasteCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kelly Senyei');
        $recipe->setCookTime(new DateInterval('PT25M'));
        $recipe->setDescription('Fire up the flames for the ultimate grilled flatbread pizza recipe starring creamy avocado pesto, fresh corn and melted mozzarella.');
        $recipe->setImage('http://www.justataste.com/wp-content/uploads/2016/06/grilled-flatbread-pizza-photo-580x875.jpg');
        $recipe->setName('Grilled Flatbread Pizzas with Avocado Pesto');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeCategories([
            'Entrées',
            'Recipes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Avocado Pesto',
                'data'  => [
                    '1 large avocado, peeled and pitted',
                    '2 cups lightly packed fresh basil leaves',
                    '2 Tablespoons grated Parmesan cheese',
                    '3 medium cloves garlic, chopped',
                    '2 Tablespoons unsalted pistachios, toasted',
                    '1/4 cup olive oil',
                ],
            ],
            [
                'title' => 'For The Flatbread Pizzas',
                'data'  => [
                    '2 large ears corn, shucked',
                    '2 Tablespoons unsalted butter, softened',
                    '4 store-bought flatbreads (or naan)',
                    '2 Tablespoons olive oil',
                    '2 cups shredded Gruyere cheese',
                    '1 cup sliced fresh mozzarella cheese',
                    '1/2 cup thinly sliced red onions',
                    '1 cup arugula',
                    'Crushed red pepper flakes, for serving (optional)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'In a blender, make the pesto by combining the avocado, basil leaves, Parmesan cheese, garlic, pistachios, 1/2 teaspoon salt and 1/4 teaspoon pepper. Pulse until the mixture is roughly chopped, then with the blender running, slowly stream in the olive oil. Continue blending the pesto until it is a thick paste, scraping down the sides of the blender as needed. Set the pesto aside.',
                    'Preheat the grill for 10 minutes on medium heat. Spread 1 tablespoon butter on each ear of corn then wrap them in Reynolds Wrap® Aluminum Foil. Place the corn on the grill, close the lid and grill the corn, turning it frequently, until it is tender, 15 to 20 minutes. Unwrap the corn, and once it is cool enough to handle, slice the kernels off the cob.',
                    'Brush both sides of the flatbreads with olive oil then grill them for 1 to 2 minutes on each side. Remove the flatbreads from the grill and top them with the avocado pesto, leaving a 1/2-inch border around the edges. Top the pesto with the Gruyere cheese, mozzarella cheese, red onions and corn. Return the flatbreads to the grill, close the lid and grill them until the cheese is melted.',
                    'Remove the flatbreads from the grill and transfer them to serving plates. Top the flatbreads with the arugula and a sprinkle of crushed red pepper flakes (optional) then slice and serve immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.justataste.com/grilled-flatbread-pizzas-avocado-pesto-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/grilled-flatbread-pizzas-avocado-pesto-recipe/'
        );
        $scraper = new JustATasteCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_and_instruction_groups()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Kelly Senyei');
        $recipe->setCookTime(new DateInterval('PT8M'));
        $recipe->setDescription('Chicken teriyaki makes a weekly appearance in my home, whether it\'s via the slow cooker, in the form of meatballs or as the stellar sauce atop crispy baked chicken wings. And with the perfect homemade teriyaki sauce in tote, it\'s time to wave goodbye to that bottled stuff and say hello to my go-to tips for successful teriyaki chicken stir-fry.');
        $recipe->setImage('http://www.justataste.com/wp-content/uploads/2016/03/teiryaki-chicken-stir-fry-noodles-recipe.jpg');
        $recipe->setName('Teriyaki Chicken Stir-Fry with Noodles');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeCategories([
            'Entrées',
            'Healthy',
            'Recipes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Teriyaki Sauce',
                'data'  => [
                    '1/2 cup low sodium soy sauce',
                    '1/3 cup low sodium chicken stock',
                    '1/4 cup pineapple juice',
                    '1/4 cup packed light brown sugar',
                    '2 cloves garlic, minced',
                    '1 teaspoon minced fresh ginger',
                    '2 1/2 teaspoons cornstarch',
                ],
            ],
            [
                'title' => 'For The Stir-fry',
                'data'  => [
                    '2 Tablespoons vegetable oil, divided',
                    '2 cups broccoli florets',
                    '1 cup sliced red peppers',
                    '1 1/2 cups shredded carrots',
                    '2 large boneless, skinless chicken breasts, cut into thin strips',
                    '8 ounces udon or rice noodles, cooked',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => 'Make The Teriyaki Sauce',
                'data'  => [
                    'Whisk together all of the teriyaki sauce ingredients in a medium bowl. Set the sauce aside.',
                ],
            ],
            [
                'title' => 'Make The Stir-fry',
                'data'  => [
                    'Add 1 tablespoon vegetable oil to a wok or large, tall-sided sauté pan set over medium-high heat. Add the broccoli, peppers and carrots and cook, stirring constantly, for 3 minutes until the vegetables are still crisp but tender. Transfer the vegetables to a bowl.',
                    'Add the remaining 1 tablespoon vegetable oil to the pan and place it back over medium-high heat. Add the sliced chicken and cook, stirring constantly, for about 3 minutes or until it is no longer pink. Push the chicken to the edges of the pan then add the prepared teriyaki sauce to the center of the pan. Bring the sauce to a boil and cook it until until it thickens to the consistency of syrup, about 3 minutes.',
                    'Reduce the heat to low then return the cooked vegetables to the pan and add the cooked noodles, tossing to combine. Serve the stir-fry immediately.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.justataste.com/teriyaki-chicken-stir-fry-noodles-recipe/');

        $crawler = $this->client->request(
            'GET',
            'http://www.justataste.com/teriyaki-chicken-stir-fry-noodles-recipe/'
        );
        $scraper = new JustATasteCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
