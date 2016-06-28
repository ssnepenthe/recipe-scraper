<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Potentially the same as bettycrocker.com and tablespoon.com, needs more
 *       thorough testing to confirm.
 */
class PillsburyCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
