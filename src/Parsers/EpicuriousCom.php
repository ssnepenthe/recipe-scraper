<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Add support for recipeCuisine?
 * Images appear to depend on javascript. Is it worth setting up something like
 * a phantomjs service for cases like this?
 */
class EpicuriousCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipe_instructions'] = [ './/*[@itemprop="recipeInstructions"]//li[@class="preparation-step"]', [ 'nodeValue' ] ];
	}
}
