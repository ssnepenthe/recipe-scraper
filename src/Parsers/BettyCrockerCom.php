<?php

namespace SSNepenthe\RecipeParser\Parsers;

class BettyCrockerCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = [ './/div[contains(@class, "recipePartRecipeImage")]/noscript/img', [ '@src' ] ];
		$this->paths['recipe_instructions'] = [ './/*[@itemprop="recipeInstructions"]', [ 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}

	protected function recipe_instructions() {
		parent::recipe_instructions();

		$this->recipe->recipe_instructions = array_map(
			[ $this, 'strip_leading_numbers' ],
			$this->recipe->recipe_instructions
		);
	}
}
