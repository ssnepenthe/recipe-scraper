<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Normalizers\Name;

/**
 * @todo Need to revisit times.
 *       Can we pull a larger image from somewhere?
 *       Cuisine exists in JS vars, haven't found it anywhere in HTML.
 *       Yield includes serving size...
 */
class MyRecipesCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['author']['selector'] = '[itemprop="author"] [itemprop="name"]';
        // Having trouble getting name, I think because it is in a <p> within a <h1> which is not valid.
        $this->config['name']['selector'] = '[property="og:title"]';
        $this->config['name']['normalizers'][] = Name::class;
        $this->config['publisher']['selector'] = '.field-sponsor';
        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] p';
        $this->config['totalTime']['selector'] = '.recipe-totaltime-duration';
        $this->config['url']['selector'] = '[rel="canonical"]';
    }
}
