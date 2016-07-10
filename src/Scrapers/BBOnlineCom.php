<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

class BBOnlineCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['cookTime']['selector'] = '.cooking-time span';
        $this->config['prepTime']['selector'] = '.prep-time span';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] p';
    }
}
