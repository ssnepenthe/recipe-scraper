<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Prep time is only accessible via a javascript object...
 *
 * image: would rather use @class="recipePartRecipeImage" for bigger image but is inconsistent.
 *
 * Consider notes: labeled tips at http://www.tablespoon.com/recipes/do-ahead-breakfast-bake-recipe/2/
 */
class TablespoonCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['recipe_category'][0] = './/*[@class="tags"]/ul/li/a';
		$this->paths['recipe_instructions'][0] = './/*[@itemprop="recipeInstructions"]/span[@class="recipePartStepDescription"]';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
	}
}
