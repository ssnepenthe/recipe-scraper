<?php

use SSNepenthe\RecipeScraper\ScraperLocator;
use SSNepenthe\RecipeScraper\Exception\NoMatchingScraperException;

class ScraperLocatorTest extends CachedHTTPTestCase
{
    public function test_return_scraper_based_on_url()
    {
        $test = [
            'http://allrecipes.com/recipe/8652/garlic-chicken/' => 'AllRecipesCom',
            'http://www.bbonline.com/recipes/buffalo-3531.html' => 'BBOnlineCom',
            'http://www.bettycrocker.com/recipes/lemon-burst-cupcakes/a15fc1ac-800b-462f-8c4f-ff81d2c91964' => 'BettyCrockerCom',
            'http://www.bhg.com/recipe/meat/bavarian-pork-roast/' => 'BHGCom',
            'http://www.cookingchanneltv.com/recipes/tia-mowry/lamb-burgers.html' => 'CookingChannelTVCom',
            'http://www.delish.com/cooking/recipe-ideas/recipes/a33641/fish-veggie-chowder-121971/' => 'DelishCom',
            'http://www.epicurious.com/recipes/food/views/Salmon-Burgers-with-Lemon-and-Capers-103498' => 'EpicuriousCom',
            'http://www.foodandwine.com/recipes/baby-brioches-with-chicken-salad-and-bacon' => 'FoodAndWineCom',
            'http://www.foodnetwork.com/recipes/trisha-yearwood/baked-macaroni-and-cheese.html' => 'FoodNetworkCom',
            'http://www.justataste.com/spanish-tortilla-tomato-salad-recipe/' => 'JustATasteCom',
            'http://www.marthastewart.com/335578/roasted-red-pepper-olive-and-caper-brusc?czone=entertaining/holiday-entertaining/holidaycenter-foods&amp;center=276958&amp;gallery=275480&amp;slide=255056' => 'MarthaStewartCom',
            'http://www.myrecipes.com/recipe/green-beans-with-shallots-0' => 'MyRecipesCom',
            'http://www.pauladeen.com/waynes-beef-macaroni-and-cheese' => 'PaulaDeenCom',
            'https://www.pillsbury.com/recipes/slow-cooker-cheesy-chicken-enchilada-chili/389d56ac-2840-4327-a23b-1303539a7248' => 'PillsburyCom',
            'http://spryliving.com/recipes/grilled-salmon-with-pesto/' => 'SpryLivingCom',
            'http://www.tablespoon.com/recipes/do-ahead-breakfast-bake/346b7c54-126f-46d7-b90c-7d3acf389d77' => 'TablespoonCom',
            'http://www.tasteofhome.com/recipes/salmon-patties-with-caper-mayonnaise' => 'TasteOfHomeCom',
            'http://thepioneerwoman.com/cooking/drip-beef-two-ways/' => 'ThePioneerWomanCom',
        ];

        foreach ($test as $url => $class) {
            $class = sprintf('SSNepenthe\\RecipeScraper\\Scrapers\\%s', $class);

            $located = (new ScraperLocator(
                $this->client->request('GET', $url)
            ))->locate();

            $this->assertEquals(
                $class,
                $located
            );
        }
    }

    // @todo Test return parser based on markup.

    public function test_throw_exception_when_parser_not_found()
    {
        $this->expectException(NoMatchingScraperException::class);

        (new ScraperLocator(
            $this->client->request('GET', 'https://www.google.com')
        ))->locate();
    }
}
