<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * Also has nutrition info and notes/tips.
 *
 * Site has articles that include a recipe but without a lot of the details.
 * There is a link to the actual recipe within the page.
 *
 * Looks like recipes are shared across the network so canonical may point to a different domain.
 */
class PillsburyCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['description']['selector'] = '[itemprop="description"]';
        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '.recipePartIngredientGroup h2, [itemprop="ingredients"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
