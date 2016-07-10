<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * FYI there is a JSON API if you send header 'Accept: application/json'.
 *
 * @todo  They have nutrition info if we want it.
 *        Calculate total time from prep + cook times.
 */
class BHGCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        // They are labeling times as cookingMethod so just use a fake selector.
        $this->config['cookingMethod']['selector'] = '.fake-selector';
        $this->config['image']['selector'] = '[itemtype*="schema.org/Recipe"] [itemprop="thumbnail"]';
        $this->config['name']['selector'] = 'h1[itemprop="name"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
    }
}
