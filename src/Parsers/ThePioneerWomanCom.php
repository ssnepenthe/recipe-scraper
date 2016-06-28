<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * @todo More testing on description.
 *       Image size appears to be modified after page load. Can potentially get
 *       original image by grabbing the parent <a> of the selected <img>.
 *       Post has author at [rel="author"], but maybe not great for recipe.
 */
class ThePioneerWomanCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        // Get first image in .entry-content.
        $this->config['image']['selector'] = '.entry-content img:first-child';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"]';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }

    protected function fetchRecipeInstructions(\DOMNodeList $nodes)
    {
        return $this->itemFromNodeList($nodes, 'recipeInstructions');
    }

    protected function formatCookTime($value)
    {
        if (! $value) {
            return $value;
        }

        return \DateInterval::createFromDateString($value);
    }

    protected function formatPrepTime($value)
    {
        if (! $value) {
            return $value;
        }

        return \DateInterval::createFromDateString($value);
    }

    protected function formatTotalTime($value)
    {
        if (! $value) {
            return $value;
        }

        return \DateInterval::createFromDateString($value);
    }
}
