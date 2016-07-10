<?php

use SSNepenthe\RecipeScraper\Scrapers\EpicuriousCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class EpicuriousComTest extends CachedHTTPTestCase
{
    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setAuthor('Alison Roman');
        $recipe->setDescription('Chicken breasts aren\'t the only cut sold skinless and boneless. Thighs are, too. They\'re fattier than breasts, which means they\'re more flavorful; plus, they\'re less expensive. Put them to work in any fast weeknight preparation, starting with these spiced tacos.');
        $recipe->setImage('http://assets.epicurious.com/photos/54af451f4074bdfd06837f8c/master/pass/51175340_grilled-chicken-tacos_1x1.jpg');
        $recipe->setName('Grilled Chicken Tacos');
        $recipe->setPublisher('Bon Appétit');
        $recipe->setRecipeCategories([
            'Chicken',
            'Low Fat',
            'Kid-Friendly',
            'Quick & Easy',
            'Backyard BBQ',
            'Summer',
            'Grill',
            'Grill/Barbecue',
            'Healthy',
            'Tortillas',
            'Bon Appétit',
        ]);
        $recipe->setRecipeCuisines(['Mexican']);
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data' => [
                    '1 medium onion, cut into wedges, keeping root intact',
                    '2 garlic cloves, finely chopped',
                    '1 pound skinless, boneless chicken thighs',
                    '1 tablespoon cumin seeds, coarsely crushed',
                    '1 tablespoon vegetable oil',
                    '1 teaspoon kosher salt',
                    '1/2 teaspoon freshly ground black pepper',
                    '8 corn tortillas, warmed (for serving)',
                    '2 avocados, sliced (for serving)',
                    'Charred Tomatillo Salsa Verde (for serving)',
                    'Cilantro sprigs, sliced radishes, and lime wedges (for serving)',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data' => [
                     'Prepare grill for medium-high heat. Toss onion, garlic, chicken, cumin, oil, salt, and pepper in a medium bowl. Grill onion and chicken until cooked through and lightly charred, about 4 minutes per side.',
                    'Let chicken rest 5 minutes before slicing. Serve with tortillas, avocados, Charred Tomatillo Salsa Verde, cilantro, radishes, and lime wedges.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setUrl('http://www.epicurious.com/recipes/food/views/grilled-chicken-tacos-51175340');

        $crawler = $this->client->request(
            'GET',
            'http://www.epicurious.com/recipes/food/views/grilled-chicken-tacos-51175340'
        );
        $scraper = new EpicuriousCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
