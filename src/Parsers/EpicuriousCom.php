<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Add support for recipeCuisine?
 *
 * Images appear to depend on javascript. Is it worth setting up something like
 * a phantomjs service for cases like this?
 *
 * what about notes? see http://www.epicurious.com/recipes/food/views/Bourbon-Balls-367849
 */
class EpicuriousCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['recipe_instructions'][0] = './/*[@itemprop="recipeInstructions"]//li[@class="preparation-step"]';
	}
}
