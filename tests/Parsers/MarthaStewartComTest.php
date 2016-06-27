<?php

use SSNepenthe\RecipeParser\Parsers\MarthaStewartCom;
use SSNepenthe\RecipeParser\Schema\Recipe;

class MarthaStewartComTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new MarthaStewartCom;
    }

    public function test_parse_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Unlike traditional Caesar salad, ours uses no oil in the dressing. Instead, it relies on tangy low-fat buttermilk. Multigrain croutons also help save on calories and splurge on flavor.');
        $recipe->setImage('http://www.marthastewart.com/sites/files/marthastewart.com/styles/wmax-520-highdpi/public/d26/med102917_0507_cesearsalad/med102917_0507_cesearsalad_vert.jpg?itok=JxEad2Ps');
        $recipe->setName('Buttermilk Chicken Caesar Salad');
        $recipe->setPrepTime(new DateInterval('PT15M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '1 1/2 cups low-fat buttermilk',
                    '2 tablespoons fresh lemon juice',
                    '1 garlic clove, pressed through a garlic press',
                    '1/4 cup grated Parmesan cheese',
                    'Coarse salt and ground pepper',
                    '3 boneless, skinless chicken breast halves (6 to 8 ounces each)',
                    '2 slices multigrain bread',
                    '1 tablespoon olive oil',
                    '1/4 cup light mayonnaise',
                    '2 medium heads (1 1/2 pounds total) romaine lettuce, cut into pieces',
                    '1/2 small head radicchio, thinly sliced',
                ],
            ]
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Heat broiler, with rack set 4 inches from heat. Line a rimmed baking sheet with aluminum foil. In a medium bowl, combine buttermilk, lemon juice, garlic, and Parmesan. Season with salt and pepper.',
                    'Place chicken in a resealable plastic bag; reserving 1/2 cup for salad, add buttermilk mixture. Refrigerate chicken at least 15 minutes and up to 1 day.',
                    'Meanwhile, make croutons: Place bread on prepared baking sheet. Brush both sides with oil, and season with salt and pepper. Broil until toasted, 1 to 2 minutes per side; cut into 1-inch pieces (and reserve baking sheet).',
                    'Transfer chicken to baking sheet; discard marinade. Broil until opaque throughout, 14 to 16 minutes. Let rest 5 minutes; thinly slice crosswise. In a large bowl, stir together mayonnaise and reserved buttermilk mixture. Add romaine, radicchio, chicken, and croutons; toss to combine. Serve immediately.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('4');
        $recipe->setTotalTime(new DateInterval('PT40M'));
        $recipe->setUrl('http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad');

        $this->assertEquals(
            $recipe,
            $this->recipe(
                'http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad'
            )
        );
    }
}
