<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo More thorough testing on description.
 *       Keep hors d'oeuvres in yield or no? See tests.
 */
class FoodAndWineCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['author']['selector'] = '[itemprop="author"] [itemprop="name"]';
        $this->config['description']['selector'] = '[itemprop="description"] + p';
        $this->config['name']['selector'] = 'h1[itemprop="name"]';
        $this->config['recipeCategories']['selector'] = '.tags_names';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }

    protected function fetchRecipeCategories(\DOMNodeList $nodes)
    {
        $line = trim(str_replace(
            'KEY:',
            '',
            $this->itemFromNodeList($nodes, 'recipeCategories')
        ));

        return explode(', ', $line);
    }
}
