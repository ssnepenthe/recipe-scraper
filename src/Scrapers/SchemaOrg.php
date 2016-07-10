<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Formatters\Multi;
use SSNepenthe\RecipeScraper\Normalizers\Image;
use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Normalizers\Author;
use SSNepenthe\RecipeScraper\Normalizers\Number;
use SSNepenthe\RecipeScraper\Normalizers\Fraction;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\Categories;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\OrderedList;
use SSNepenthe\RecipeScraper\Normalizers\RecipeYield;
use SSNepenthe\RecipeScraper\Normalizers\RecipeInstructions;
use SSNepenthe\RecipeScraper\Transformers\ListToGroupedList;
use SSNepenthe\RecipeScraper\Transformers\StringsToIntervals;

class SchemaOrg extends BaseScraper
{
    protected function applyScraperConfig()
    {
        $this->config = [
            'author' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="author"]',
                'normalizers' => [
                    Fraction::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                    Author::class,
                ],
            ],
            'cookTime' => [
                'selector' => '[itemprop="cookTime"]',
                'transformer' => StringsToIntervals::class,
            ],
            'cookingMethod' => [
                'selector' => '[itemprop="cookingMethod"]',
            ],
            'description' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="description"]',
            ],
            'image' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="image"]',
                'normalizers' => [
                    Fraction::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                    Image::class,
                ],
            ],
            'name' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="name"]',
            ],
            'prepTime' => [
                'selector' => '[itemprop="prepTime"]',
                'transformer' => StringsToIntervals::class,
            ],
            'publisher' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="publisher"]',
            ],
            'recipeCategories' => [
                'selector' => '[itemprop="recipeCategory"]',
                'formatter' => Multi::class,
                'normalizers' => [
                    Fraction::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                    Categories::class,
                ]
            ],
            'recipeCuisines' => [
                'selector' => '[itemprop="recipeCuisine"]',
                'formatter' => Multi::class,
            ],
            'recipeIngredients' => [
                'selector' => '[itemprop="recipeIngredient"]',
                'formatter' => Multi::class,
                'transformer' => ListToGroupedList::class,
            ],
            'recipeInstructions' => [
                'selector' => '[itemprop="recipeInstructions"]',
                'formatter' => Multi::class,
                'normalizers' => [
                    Fraction::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                    OrderedList::class,
                    RecipeInstructions::class,
                ],
                'transformer' => ListToGroupedList::class,
            ],
            'recipeYield' => [
                'selector' => '[itemprop="recipeYield"]',
                'normalizers' => [
                    Fraction::class,
                    Number::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                    RecipeYield::class,
                ],
            ],
            'totalTime' => [
                'selector' => '[itemprop="totalTime"]',
                'transformer' => StringsToIntervals::class,
            ],
            'url' => [
                'selector' => '[itemtype*="schema.org/Recipe"] [itemprop="url"]',
            ],
        ];
    }
}
