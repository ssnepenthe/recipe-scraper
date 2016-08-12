<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

/**
 * @todo Has videos if we want them. See http://www.pauladeen.com/chicken-chili-stew.
 *       More thorough testing on url - there are two canonical links per page.
 *       I haven't found any with ingredient groups to test...
 */
class PaulaDeenCom extends SchemaOrg
{
    protected function applyScraperConfig()
    {
        parent::applyScraperConfig();

        $this->config['description']['selector'] = 'meta[name="description"]';
        // Use final item in breadcrumb trail so we don't have to strip byline.
        $this->config['name']['selector'] = '.breadcrumbs li:last-child';
        $this->config['recipeIngredients']['selector'] = '[itemtype*="schema.org/Recipe"] .ingredients li';
        $this->config['recipeInstructions']['selector'] = '[itemtype*="schema.org/Recipe"] .preparation p';
        $this->config['url']['selector'] = 'link[rel="canonical"]:last-of-type';
    }
}
