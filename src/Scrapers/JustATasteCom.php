<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Formatters\MultiFromChildren;

class JustATasteCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['description']['selector'] = '[name="description"]';
        $this->config['image']['selector'] = '.blog p:first-child img';
        $this->config['recipeCategories']['locations'] = ['_text'];
        $this->config['recipeCategories']['selector'] = '.category-link-single';
        $this->config['recipeIngredients']['formatter'] = MultiFromChildren::class;
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] p';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
