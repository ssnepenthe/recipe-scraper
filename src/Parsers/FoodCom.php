<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Incorrectly marks serving size as yield.
 * Screwed up fractions: http://www.food.com/recipe/baked-cinnamon-apples-crock-pot-253442
 */
class FoodCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['recipe_yield'][0] = './/a[@class="servings"]/span[@class="value"]';
	}
}
