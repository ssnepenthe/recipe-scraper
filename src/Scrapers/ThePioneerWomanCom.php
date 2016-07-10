<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\SplitOnEOL;

/**
 * @todo More testing on description.
 *       Image size appears to be modified after page load. Can potentially get
 *       original image by grabbing the parent <a> of the selected <img>.
 *       Post has author at [rel="author"], but maybe not great for recipe.
 */
class ThePioneerWomanCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        // Get first image in .entry-content.
        $this->config['image']['selector'] = '.entry-content img:first-child';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"]';
        $this->config['url']['selector'] = '[rel="canonical"]';

        $pos = array_search(
            SingleLine::class,
            $this->config['recipeInstructions']['normalizers']
        );

        unset($this->config['recipeInstructions']['normalizers'][ $pos ]);

        $this->config['recipeInstructions']['normalizers'][] = SplitOnEOL::class;
    }
}
