<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo  Has ld+json.
 *        Description needs more thorough testing.
 *        Categories can be found at very bottom of the page.
 *        Seems to have some recipes with canonical set to another site. Should we use it anyway?
 *        Looks like they share recipes across sites in their network so URL may point to another domain...
 */
class DelishCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['description']['selector'] = '.recipe-page--body-content p';
        $this->config['image']['selector'] = '[property="og:image"]';
        $this->config['recipeIngredients']['selector'] = '.recipe-ingredients-group-header, [itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
