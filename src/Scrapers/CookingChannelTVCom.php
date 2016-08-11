<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\SplitOnEOL;
use SSNepenthe\RecipeScraper\Normalizers\SpaceBetweenSentences;


class CookingChannelTVCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        // Description at default location is for brand, not recipe.
        $this->config['description']['selector'] = '.fake-selector';
        $this->config['image']['selector'] = '.photo';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"] li, [itemprop="ingredients"] span';
        $this->config['url']['selector'] = '[rel="canonical"]';

        $pos = array_search(
            SingleLine::class,
            $this->config['recipeInstructions']['normalizers']
        );

        unset($this->config['recipeInstructions']['normalizers'][ $pos ]);

        $this->config['recipeInstructions']['normalizers'][] = SplitOnEOL::class;
    }
}
