<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Can potentially get categories off of data-category attribute on ingredients.
 *       Nutrition info is there if we want it as well.
 *       There are also notes/tips.
 */
class BettyCrockerCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['image']['selector'] = '.recipePartRecipeImage noscript img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
