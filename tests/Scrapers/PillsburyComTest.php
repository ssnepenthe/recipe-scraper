<?php

use SSNepenthe\RecipeScraper\Scrapers\PillsburyCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class PillsburyComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('It’s a little bit enchilada, a little bit chili and a whole lot of yummy!');
        // Should be https but I don't have a great way to handle this yet.
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
}
