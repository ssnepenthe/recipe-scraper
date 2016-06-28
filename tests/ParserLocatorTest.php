<?php

use SSNepenthe\RecipeParser\ParserLocator;
use SSNepenthe\RecipeParser\Exception\NoMatchingParserException;

class ParserLocatorTest extends CacheableHTTPTestCase
{
    public function test_throw_exception_if_instantiated_with_non_string_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new ParserLocator(1, 'string');
    }

    public function test_throw_exception_if_instantiated_with_non_string_html()
    {
        $this->expectException(InvalidArgumentException::class);

        new ParserLocator('string', 1);
    }

    public function test_return_parser_based_on_url()
    {
        $test = [
            'http://allrecipes.com/recipe/8652/garlic-chicken/' => 'AllRecipesCom',
            'http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964' => 'BettyCrockerCom',
            'http://www.bhg.com/recipe/meat/bavarian-pork-roast/' => 'BHGCom',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a33641/fish-veggie-chowder-121971/' => 'DelishCom',
            'http://www.epicurious.com/recipes/food/views/Salmon-Burgers-with-Lemon-and-Capers-103498' => 'EpicuriousCom',
            'http://www.foodandwine.com/recipes/baby-brioches-with-chicken-salad-and-bacon' => 'FoodAndWineCom',
            'http://www.foodnetwork.com/recipes/trisha-yearwood/baked-macaroni-and-cheese.html' => 'FoodNetworkCom',
            'http://www.marthastewart.com/335578/roasted-red-pepper-olive-and-caper-brusc?czone=entertaining/holiday-entertaining/holidaycenter-foods&amp;center=276958&amp;gallery=275480&amp;slide=255056' => 'MarthaStewartCom',
            'http://www.myrecipes.com/recipe/green-beans-with-shallots-0' => 'MyRecipesCom',
            'http://www.pauladeen.com/waynes-beef-macaroni-and-cheese' => 'PaulaDeenCom',
            'http://www.tablespoon.com/recipes/do-ahead-breakfast-bake/346b7c54-126f-46d7-b90c-7d3acf389d77' => 'TablespoonCom',
            'http://www.tasteofhome.com/recipes/salmon-patties-with-caper-mayonnaise' => 'TasteOfHomeCom',
            'http://thepioneerwoman.com/cooking/drip-beef-two-ways/' => 'ThePioneerWomanCom',
        ];

        foreach ($test as $url => $class) {
            $class = sprintf('SSNepenthe\\RecipeParser\\Parsers\\%s', $class);

            $located = (new ParserLocator(
                $url,
                'not important for this test'
            ))->locate();

            $this->assertEquals(
                $class,
                $located
            );
        }
    }

    public function test_return_user_supplied_parser_based_on_url()
    {
        $class = 'GoogleCom';
        $parsers = [ 'google.com' => $class ];
        $url = 'https://www.google.com/lets/pretend/this/is/a/recipe/site';

        $located = (new ParserLocator($url, 'unimportant', $parsers))->locate();

        $this->assertEquals($class, $located);
    }

    public function test_return_user_overridden_parser_based_on_url()
    {
        $class = 'Overridden';
        $parsers = [ 'allrecipes.com' => $class ];
        $url = 'http://allrecipes.com/recipe/8652/garlic-chicken/';

        $located = (new ParserLocator($url, 'unimportant', $parsers))->locate();

        $this->assertEquals($class, $located);
    }

    public function test_return_parser_based_on_markup()
    {
        $html = $this->get_and_cache(
            'http://allrecipes.com/recipe/8652/garlic-chicken/'
        );

        $located = (new ParserLocator('http://fake.com', $html))->locate();

        $this->assertEquals(ParserLocator::SCHEMA_ORG, $located);
    }

    public function test_throw_exception_when_parser_not_found()
    {
        $this->expectException(NoMatchingParserException::class);

        (new ParserLocator('https://www.google.com', 'fake'))->locate();
    }
}
