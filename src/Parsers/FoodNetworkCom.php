<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Ideally we should leave off the last element in instructions.
 */
class FoodNetworkCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['recipe_instructions'][0] = './/*[@itemprop="recipeInstructions"]/p';
	}
}
