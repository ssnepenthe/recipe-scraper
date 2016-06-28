<?php

namespace SSNepenthe\RecipeParser\Parsers;

class SpryLivingCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['description']['selector'] = '[name="description"]';
        $this->config['image']['selector'] = '.main-image noscript img';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] li';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
