<?php

use SSNepenthe\RecipeParser\Schema\Recipe;
use SSNepenthe\RecipeParser\Parsers\MyRecipesCom;

class MyRecipesComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new MyRecipesCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Melanie Barnard');
        $recipe->setDescription('Flour tortillas stand in for the traditional biscuit dough so you can bring this crowd-pleaser from stove to table in minutes.');
        $recipe->setImage('http://cdn-image.myrecipes.com/sites/default/files/styles/300x300/public/quick-chicken-dumplings-mr.jpg?itok=7iuasoNn');
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

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.myrecipes.com/recipe/quick-chicken-dumplings-0'
            )
        );
    }

    public function test_parse_a_recipe_with_ingredient_groups()
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
                'title' => 'Remaining ingredients',
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
                    'Remove grill rack; set aside. Prepare grill for indirect grilling, heating one side to medium-low and leaving one side with no heat. Maintain temperature at 225°. Pierce bottom of a disposable aluminum foil pan several times with the tip of a knife. Place pan on heated side of grill; add half of wood chunks to pan. Place another disposable aluminum foil pan (do not pierce pan) on unheated side of grill. Pour 2 cups water in pan. Coat grill rack with cooking spray; place grill rack on grill.',
                    'Place pork on grill rack over foil pan on unheated side. Close lid; cook 4 1/2 hours or until a thermometer registers 170°, gently brushing pork with beer mixture every hour (avoid brushing off sugar mixture). Add additional wood chunks halfway during cooking time. Discard any remaining beer mixture.',
                    'Preheat oven to 250°.',
                    'Remove pork from grill. Wrap pork in several layers of aluminum foil, and place in a baking pan. Bake at 250° for 2 hours or until a thermometer registers 195°. Remove from oven. Let stand, still wrapped, 1 hour or until pork easily pulls apart. Unwrap pork; trim and discard fat. Shred pork with 2 forks.',
                    'While pork bakes, prepare slaw. Combine onion and next 5 ingredients (through 1/4 teaspoon salt) in a large bowl. Add cabbage, and toss to coat. Cover and chill 3 hours before serving. Serve pork and slaw on buns with Memphis Barbecue Sauce.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('13');
        $recipe->setUrl('http://www.myrecipes.com/recipe/memphis-pork-coleslaw-sandwich');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.myrecipes.com/recipe/memphis-pork-coleslaw-sandwich'
            )
        );
    }
}
