<?php

namespace SSNepenthe\RecipeParser\Parsers;

class AllRecipesCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipeInstructions'] = './/*[@itemprop="recipeInstructions"]/li';
	}
}
