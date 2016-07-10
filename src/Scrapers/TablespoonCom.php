<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo Has multiple images we can grab if we want.
 *       Verify consistency of .recipePartRecipeImage across multiple recipes.
 *       No great way to select prep and cook times - need to revisit.
 *       They seem to have notes/tips - see breakfast link below.
 *
 * @link http://www.tablespoon.com/recipes/copycat-in-n-out-burger-double-cheeseburger/ea7f1d77-0fbf-448d-acc4-597d8f8fccec#
 * @link http://www.tablespoon.com/recipes/do-ahead-breakfast-bake-recipe/2/
 */
class TablespoonCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

<<<<<<< HEAD:src/Parsers/TablespoonCom.php
        $this->config['author']['locations'] = ['nodeValue'];
        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['url']['selector'] = 'link[rel="canonical"]';
=======
        $this->config['author']['locations'] = ['_text'];
        $this->config['description']['selector'] = 'meta[name="description"]';
        $this->config['image']['selector'] = '.recipePartRecipeImage img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
>>>>>>> develop:src/Scrapers/TablespoonCom.php
    }
}
