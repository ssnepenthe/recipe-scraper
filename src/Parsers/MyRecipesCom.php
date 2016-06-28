<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Need to revisit times.
 *       Can we pull a larger image from somewhere?
 *       Cuisine exists in JS vars, haven't found it anywhere in HTML.
 *       Yield includes serving size...
 */
class MyRecipesCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['author']['selector'] = '[itemprop="author"] .field-author';
        $this->config['publisher']['selector'] = '.field-sponsor';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] p';
        $this->config['totalTime']['selector'] = '.recipe-totaltime-duration';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
