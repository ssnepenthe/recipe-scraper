<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo Also has cooks notes if we want them (http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad).
 *       Some have a 'variations' notes section as well.
 *       Need a lot more testing on recipeYield - might grab cook/prep time.
 *       Looks like they frequently reference other recipes within the ingredients section.
 */
class MarthaStewartCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['image']['selector'] = '[itemprop="image"] + noscript > img';
        $this->config['recipeIngredients']['selector'] = '.col1 .components-group-header, [itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '.directions-item-text';
        $this->config['recipeYield']['selector'] = '[itemprop="recipeYield"], .mslo-credits:last-child';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
