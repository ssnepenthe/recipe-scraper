<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

class TasteOfHomeCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['image']['selector'] = 'meta[itemprop="image"]';
        $this->config['name']['selector'] = 'h1[itemprop="name"]';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '.rd_directions .rd_name';
        $this->config['recipeYield']['selector'] = '[itemprop="recipeyield"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
