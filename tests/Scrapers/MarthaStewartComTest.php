<?php

use SSNepenthe\RecipeScraper\Scrapers\MarthaStewartCom;
use SSNepenthe\RecipeScraper\Schema\Recipe;

class MarthaStewartComTest extends CachedHTTPTestCase
{
    public function test_scrape_a_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Unlike traditional Caesar salad, ours uses no oil in the dressing. Instead, it relies on tangy low-fat buttermilk. Multigrain croutons also help save on calories and splurge on flavor.');
        $recipe->setImage('http://assets.marthastewart.com/styles/wmax-520-highdpi/d26/med102917_0507_cesearsalad/med102917_0507_cesearsalad_vert.jpg?itok=_s2SNifv');
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

        $crawler = $this->client->request(
            'GET',
            'http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad'
        );
        $scraper = new MarthaStewartCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_standard_recipe()
    {
        $recipe = new Recipe;
        $recipe->setDescription('This classic Italian egg dish is its country\'s answer to the French omelet -- but much more versatile. It\'s great for breakfast, lunch, and dinner, and delicious hot or at room temperature. Once you get the basics down, check out our variations below.');
        $recipe->setImage('http://assets.marthastewart.com/styles/wmax-520-highdpi/d20/frittata-062-d112989/frittata-062-d112989_vert.jpg?itok=7-jLdUlf');
        $recipe->setName('Perfect Frittata with Zucchini and Provolone');
        $recipe->setPrepTime(new DateInterval('PT25M'));
        $recipe->setRecipeIngredients([
            [
                'title' => '',
                'data'  => [
                    '3 tablespoons butter',
                    '1 cup sliced scallions (about 6)',
                    '3/4 teaspoon coarse salt, divided',
                    '2 cups thinly sliced zucchini (about 1 medium)',
                    '12 large eggs',
                    '1/4 cup whole milk',
                    '1/4 cup thinly sliced fresh basil',
                    '1/4 teaspoon freshly ground pepper',
                    '3/4 cup grated provolone (2 1/2 ounces)',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Preheat broiler with rack 6 inches from heating element. Melt butter in a 10-inch broilerproof nonstick skillet over medium-high. Add scallions and 1/4 teaspoon salt; cook until tender, 2 to 5 minutes. Stir in zucchini and cook until tender, 4 to 8 minutes. (This ensures that the vegetables are cooked and won\'t release extra moisture, which would make the frittata tough and watery.)',
                    'Meanwhile, beat together eggs and milk with a fork (it gives you more speed and agility than a whisk here) until well combined. Stir in basil, 1/2 teaspoon salt, and pepper. Pour egg mixture into skillet; cook over medium-high, stirring with a spatula to create large curds, until eggs are wet on top but otherwise set throughout, 2 to 3 minutes.',
                    'Sprinkle with provolone, pressing about half down into eggs. Transfer to oven; broil until puffed and browning in spots and eggs are just set, 1 to 2 minutes. Let stand 10 minutes before slicing. Frittata can be served hot or at room temperature.',
                ],
            ],
        ]);
        $recipe->setRecipeYield('6 to 8');
        $recipe->setTotalTime(new DateInterval('PT35M'));
        $recipe->setUrl('http://www.marthastewart.com/1157761/perfect-frittata-zucchini-and-provolone');

        $crawler = $this->client->request(
            'GET',
            'http://www.marthastewart.com/1157761/perfect-frittata-zucchini-and-provolone'
        );
        $scraper = new MarthaStewartCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_a_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('In this vegetarian Vietnamese appetizer, cellophane noodles, fried tofu, sauteed shallots, crunchy lettuce, carrots, and jicama are topped by a sprinkling of herbs and rolled in diaphanous rice paper rounds.');
        $recipe->setImage('http://assets.marthastewart.com/styles/wmax-520-highdpi/d27/summer-rolls-0506-mla101625/summer-rolls-0506-mla101625_vert.jpg?itok=_oqNZppX');
        $recipe->setName('Summer Rolls with Peanut Dipping Sauce');
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Assembly',
                'data'  => [
                    '16 round (8-inch) rice-paper wrappers',
                    '2 small heads Boston or butter lettuce, leaves separated and ribs removed',
                    '2/3 cup tightly packed Thai basil leaves',
                    '2/3 cup tightly packed cilantro leaves',
                    'Peanut Dipping Sauce for Summer Rolls',
                ],
            ],
            [
                'title' => 'For The Filling',
                'data'  => [
                    '2 ounces bean threads',
                    '1/4 cup vegetable oil',
                    '6 shallots, thinly sliced into rings',
                    '2 packages (11 ounces each) fried tofu, cut into 2-inch-long, 1/4-inch-thick sticks',
                    '1/4 cup soy sauce',
                    '1 ounce jicama, peeled and cut into matchsticks (about 2 cups)',
                    '12 ounces large carrots, peeled and cut into matchsticks (about 2 cups)',
                    'Coarse salt and freshly ground pepper',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Make the filling: Soak bean threads in hot water for 20 minutes. Drain, and rinse in cold water. Cut into 2-inch lengths.',
                    'Heat 2 tablespoons oil in a large skillet over medium heat. Add shallots; cook, stirring occasionally, until golden brown, about 5 minutes. Using a slotted spoon, transfer to a small bowl; set aside.',
                    'Add tofu to skillet; cook, stirring, 3 minutes. Add 1 tablespoon soy sauce; cook 1 minute more. Transfer to a large bowl.',
                    'Add remaining 2 tablespoons oil to skillet; heat until hot but not smoking. Add jicama and carrots; cook, stirring occasionally, 3 minutes. Add bean threads and remaining 3 tablespoons soy sauce; cook, stirring occasionally, 2 minutes. Season with salt and pepper. Transfer to bowl with tofu; stir to combine.',
                    'To assemble each roll, soak a wrapper in a bowl of warm water until softened, about 30 seconds. Transfer to a work surface. Lay 1 or 2 lettuce leaves lengthwise at 1 end of wrapper. Spread 1/2 cup tofu mixture over lettuce; sprinkle with shallots. Top with basil and cilantro. Fold ends in and roll tightly to enclose filling. Cover with a damp cloth until ready to serve. Halve rolls. Serve with dipping sauce.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('16');
        $recipe->setUrl('http://www.marthastewart.com/1160422/summer-rolls-peanut-dipping-sauce');

        $crawler = $this->client->request(
            'GET',
            'http://www.marthastewart.com/1160422/summer-rolls-peanut-dipping-sauce'
        );
        $scraper = new MarthaStewartCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }

    public function test_scrape_another_recipe_with_ingredient_groups()
    {
        $recipe = new Recipe;
        $recipe->setDescription('Baked in coarse salt to seal in the juices, these lemon-topped rounds of tender chicken reveal an asparagus-and-Parmesan stuffed center.');
        $recipe->setImage('http://assets.marthastewart.com/styles/wmax-520-highdpi/d27/salt-chicken-0406-mla102006/salt-chicken-0406-mla102006_vert.jpg?itok=12QCyQ1z');
        $recipe->setName('Salt-Baked Chicken Breast Stuffed with Asparagus');
        $recipe->setRecipeIngredients([
            [
                'title' => 'For The Chicken',
                'data'  => [
                    '1 large whole chicken (about 7 1/2 pounds)',
                    '2 lemons, very thinly sliced (less than 1/8 inch thick)',
                    '2 large fresh tarragon sprigs',
                ],
            ],
            [
                'title' => 'For The Filling',
                'data'  => [
                    'Coarse salt',
                    '2 bunches thin asparagus (about 2 pounds), trimmed',
                    '2 tablespoons olive oil',
                    '1 small leek, white and pale-green parts only, rinsed well and patted dry, finely chopped',
                    '2 garlic cloves, minced',
                    'Freshly ground pepper',
                    '2 tablespoons heavy cream',
                    '1/3 cup finely grated fresh Parmesan cheese',
                    '1/3 cup fresh breadcrumbs (from crustless bread)',
                    '2 tablespoons fresh lemon juice',
                ],
            ],
            [
                'title' => 'For The Crust',
                'data'  => [
                    '6 cups coarse salt',
                    '3 large egg whites',
                    '1 tablespoon fresh tarragon leaves',
                ],
            ],
            [
                'title' => 'For Serving',
                'data'  => [
                    'Extra-virgin olive oil',
                    'Lemon juice',
                    'Coarse salt',
                    'Wild Mushrooms with Red Onions and Scallions',
                ],
            ],
        ]);
        $recipe->setRecipeInstructions([
            [
                'title' => '',
                'data'  => [
                    'Prepare the chicken: Cut all breast meat from bone in one piece, leaving the skin intact. Cut off tenders from breast. Remove enough thigh meat (without skin) to measure about 1/2 pound; cut into 1-inch pieces, and refrigerate until ready to use. Using a sharp knife, butterfly the thickest part of the breast, and fold thin parts down so that breast is of even thickness all over. Cover with plastic wrap, and refrigerate until cold.',
                    'Meanwhile, make the filling: Bring a large stockpot of water to a boil; add 1 tablespoon salt. Prepare an ice-water bath; set aside. Add asparagus to the boiling water, and cook until asparagus is bright green and tender, 2 to 3 minutes. Plunge asparagus into ice-water bath to stop the cooking. Drain, and pat dry with paper towels; set aside.',
                    'Heat oil in a medium skillet over medium-low heat. Add leek and garlic; season with salt and pepper. Cook, stirring occasionally, until leek is soft and translucent, about 5 minutes. Remove from heat, and let stand until cool.',
                    'Transfer the leek mixture to a food processor; pulse until coarsely pureed. Add reserved thigh meat, and pulse to combine. Add the cream and 1 teaspoon salt; pulse. Add the Parmesan cheese, breadcrumbs, and lemon juice, and pulse until filling is fully combined and finely chopped (you should have about 1 cup filling); set filling aside.',
                    'Preheat oven to 400 degrees. Stuff the chicken: Using your fingers, loosen skin from breast meat. Slide 3 lemon slices and 1 tarragon sprig between skin and meat of each side of breast. Lay breast, skin side down, on a double layer of cheesecloth (about 18 by 24 inches). Spread 3/4 cup reserved filling over center of breast. Arrange about 10 asparagus spears over filling; reserve remaining asparagus for serving. Spread remaining 1/4 cup filling over top of asparagus.',
                    'Fold both sides of breast toward center to enclose filling; secure with toothpicks. Cover any skinless areas of meat with remaining lemon slices. Wrap chicken tightly in the cheesecloth, and tie up with kitchen twine, forming a log (about 9 inches long and 5 inches in diameter). The chicken can be prepared ahead up to this point and refrigerated, wrapped in plastic, up to 1 day.',
                    'Make the crust: Using your hands, combine salt, egg whites, and 2 tablespoons water. Stir in tarragon leaves. Using about 1/2 cup of the salt mixture, make a bed in a large baking dish. Place cheesecloth-wrapped chicken, seam side down, on top of salt. Pat remaining salt mixture over chicken, covering it completely with a 1/2-inch-thick layer.',
                    'Bake the chicken until an instant-read thermometer inserted through the crust into the center of filling registers 155 degrees, about 1 hour 10 minutes (begin checking after 1 hour). Remove chicken from oven; let stand at room temperature until thermometer reaches 165 degrees, about 10 minutes.',
                    'Break off crust; discard. Let chicken stand for at least 30 minutes before slicing. Remove cheesecloth, and discard. Transfer chicken to a cutting board, and cut into 1/2-inch-thick slices. Drizzle remaining asparagus with oil and lemon juice, and sprinkle with salt. Serve chicken warm or at room temperature with the asparagus. Serve wild mushrooms with red onions and scallions on the side.',
                ],
            ]
        ]);
        $recipe->setRecipeYield('8');
        $recipe->setUrl('http://www.marthastewart.com/1160377/salt-baked-chicken-breast-stuffed-asparagus');

        $crawler = $this->client->request(
            'GET',
            'http://www.marthastewart.com/1160377/salt-baked-chicken-breast-stuffed-asparagus'
        );
        $scraper = new MarthaStewartCom($crawler);

        $this->assertEquals($recipe, $scraper->scrape());
    }
}
