<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo  Some have notes if we want them. See http://www.epicurious.com/recipes/food/views/Bourbon-Balls-367849
 *        Has nutrition info if we want it.
 */
class EpicuriousCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['recipeCategories']['locations'] = ['_text'];
        $this->config['recipeCuisines']['locations'] = ['_text'];

        $this->config['recipeIngredients']['selector'] = '.ingredient-group strong, [itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '.preparation-group strong, .preparation-step';
    }
}
