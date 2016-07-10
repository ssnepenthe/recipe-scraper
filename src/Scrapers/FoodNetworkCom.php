<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeParser\Util\Format;
use SSNepenthe\RecipeParser\Util\Normalize;

/**
 * @todo Potentially more categories available with javascript support.
 */
class FoodNetworkCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['author']['selector'] = '[itemprop="author"] [itemprop="name"]';

        // I don't want the description they actually provide.
        $this->config['description']['selector'] = '.fake-selector';

        $this->config['image']['selector'] = '.photo-video [itemprop="image"]';
        $this->config['recipeIngredients']['selector'] = '.ingredients li';
        $this->config['recipeInstructions']['selector'] = '.recipe-directions-list li';
    }
}
