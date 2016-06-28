<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Has videos if we want them. See http://www.pauladeen.com/chicken-chili-stew.
 *       More thorough testing on url - there are two canonical links per page.
 */
class PaulaDeenCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['description']['selector'] = 'meta[name="description"]';
        $this->config['recipeIngredients']['selector'] = '[itemtype*="schema.org/Recipe"] .ingredients li';
        $this->config['recipeInstructions']['selector'] = '[itemtype*="schema.org/Recipe"] .preparation p';
        $this->config['url']['selector'] = 'link[rel="canonical"]:last-of-type';
    }

    /**
     * Gets the first text node child and leaves the span behind.
     *
     * @param  DOMNodeList $nodelist List of node retrieved from DOM.
     *
     * @return string
     */
    protected function fetchName($nodelist)
    {
        return $nodelist->item(0)->childNodes->item(0)->nodeValue;
    }
}
