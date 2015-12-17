<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Ideally we should leave off the last element in instructions.
 */
class FoodNetworkCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipe_instructions'] = [ './/*[@itemprop="recipeInstructions"]/p', [ 'nodeValue' ] ];
	}
}
