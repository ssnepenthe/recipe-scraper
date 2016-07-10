<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Normalizers\SplitOnComma;

/**
 * @todo More thorough testing on description.
 *       Keep hors d'oeuvres in yield or no? See tests.
 */
class FoodAndWineCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['author']['selector'] = '[itemprop="author"] [itemprop="name"]';
        $this->config['description']['selector'] = '[itemprop="description"] + p';
        $this->config['name']['selector'] = 'h1[itemprop="name"]';
        $this->config['recipeCategories']['selector'] = '.tags_names';
        $this->config['recipeCategories']['normalizers'][] = SplitOnComma::class;
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
