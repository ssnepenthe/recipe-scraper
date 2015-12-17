<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Incorrectly marks serving size as yield.
 * Screwed up fractions: http://www.food.com/recipe/baked-cinnamon-apples-crock-pot-253442
 */
class FoodCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipe_yield'] = [ './/a[@class="servings"]/span[@class="value"]', [ 'nodeValue' ] ];
	}
}
