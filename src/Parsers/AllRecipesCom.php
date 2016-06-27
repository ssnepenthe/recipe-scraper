<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo  Has notes if we want them.
 */
class AllRecipesCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['description']['selector'] = 'meta[itemprop="description"]';
        $this->config['image']['selector'] = 'meta[itemprop="image"]';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
    }
}
