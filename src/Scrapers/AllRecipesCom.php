<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo  Has notes if we want them.
 */
class AllRecipesCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
    }
}
