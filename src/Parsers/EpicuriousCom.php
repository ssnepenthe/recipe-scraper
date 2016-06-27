<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo  Some have notes if we want them. See http://www.epicurious.com/recipes/food/views/Bourbon-Balls-367849
 *        Has nutrition info if we want it.
 */
class EpicuriousCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['recipeCategories']['locations'] = ['nodeValue'];
        $this->config['recipeCuisines']['locations'] = ['nodeValue'];

        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '.preparation-step';
    }
}
