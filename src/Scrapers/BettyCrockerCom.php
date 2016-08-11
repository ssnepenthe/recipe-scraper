<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Formatters\MultiFromChildren;

/**
 * @todo Can potentially get categories off of data-category attribute on ingredients.
 *       Nutrition info is there if we want it as well.
 *       There are also notes/tips.
 */
class BettyCrockerCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '.recipePartIngredientGroup h2, .recipePartIngredientGroup dl';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
