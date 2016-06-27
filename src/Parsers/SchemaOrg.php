<?php

namespace SSNepenthe\RecipeParser\Parsers;

use SSNepenthe\RecipeParser\Util\Format;
use SSNepenthe\RecipeParser\Util\Normalize;

class SchemaOrg extends BaseParser
{
    protected function configure()
    {
        $this->config = [
            'author' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="author"]',
            ],
            'cookTime' => [
                'selector' => '[itemprop="cookTime"]',
            ],
            'cookingMethod' => [
                'selector' => '[itemprop="cookingMethod"]',
            ],
            'description' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="description"]',
            ],
            'image' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="image"]',
            ],
            'name' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="name"]',
            ],
            'prepTime' => [
                'selector' => '[itemprop="prepTime"]',
            ],
            'publisher' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="publisher"]',
            ],
            'recipeCategories' => [
                'selector' => '[itemprop="recipeCategory"]',
            ],
            'recipeCuisines' => [
                'selector' => '[itemprop="recipeCuisine"]',
            ],
            'recipeIngredients' => [
                'selector' => '[itemprop="recipeIngredient"]',
            ],
            'recipeInstructions' => [
                'selector' => '[itemprop="recipeInstructions"]',
            ],
            'recipeYield' => [
                'selector' => '[itemprop="recipeYield"]',
            ],
            'totalTime' => [
                'selector' => '[itemprop="totalTime"]',
            ],
            'url' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="url"]',
            ],
        ];
    }
}
