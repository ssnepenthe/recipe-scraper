<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * Also has nutrition info and notes/tips.
 */
class PillsburyCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['description']['selector'] = '[itemprop="description"]';
        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
