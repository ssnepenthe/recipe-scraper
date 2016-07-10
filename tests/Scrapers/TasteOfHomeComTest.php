<?php

use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Scrapers\TasteOfHomeCom;

class TasteOfHomeComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setCookTime(new DateInterval('PT10M'));
        $recipe->setImage('http://cdn1.tmbi.com/TOH/Images/Photos/37/300x300/exps39678_SD132779A06_11_1b.jpg');
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
}
