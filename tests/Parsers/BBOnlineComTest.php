<?php

use SSNepenthe\RecipeParser\Parsers\BBOnlineCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class BBOnlineComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new BBOnlineCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Buffalo Tavern Bed and Breakfast');
        $recipe->setCookTime(new DateInterval('PT45M'));
        $recipe->setDescription('This has been a staple recipe for me for quite some time. It\'s easy and has so many variations you can choose! My guests love it.');
        $recipe->setImage('http://avatars.ibsrv.net/ibsrv/res/20111205/src:images.bbonline.com/get/fullsize/2/1/5/5/6/6/1/2013-08-10_09-01-55_464.jpg');
        $recipe->setName('Easy Herb-Baked Eggs');
        $recipe->setPrepTime(new DateInterval('PT20M'));
        $recipe->setRecipeCategories([
            'Breakfast',
            'Other Egg Dishes',
        ]);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '2 tbs. mustard (your choice)',
                    '8 tbs. balsamic glaze',
                    '24 eggs',
                    '4 cups hash browns',
                    '8 slices tomato (fresh)',
                    '8 leaves basil',
                    '4 cups shredded mild cheddar',
                    '8 tbs. sour cream',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'I use 5 x 5 individual ramekins. Spray each ramekin with non-stick spray. Place 1/2 cup of hashbrowns in each. Then add one tomato slice and basil (fresh pieces if possible or, off season, dry). Add 1/2 cup cheese.',
                    'Mix in large bowl the eggs, sour cream, and mustard. Put a cup of egg mixture in each ramekin. Keep using the egg mixture until it is gone. You should have none left and full ramekins.',
                    'Put in a heated 350 degree oven for 45 minutes. It will bubble up. Just before serving put some balsamic glaze on top (available in your local store.). Serve hot.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('8');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.bbonline.com/recipes/buffalo-3531.html'
            )
        );
    }
}
