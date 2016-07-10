<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Formatters\MultiFromChildren;

class SpryLivingCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['image']['locations'] = ['data-lazy-src'];
        $this->config['image']['selector'] = '.main-image img[class*="wp-"]';
        $this->config['recipeIngredients']['formatter'] = MultiFromChildren::class;
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['formatter'] = MultiFromChildren::class;
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
