<?php

namespace SSNepenthe\RecipeParser\Parsers;

class BettyCrockerCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/div[contains(@class, "recipePartRecipeImage")]/noscript/img';
		$this->paths['recipe_instructions'][0] = './/*[@itemprop="recipeInstructions"]';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
	}

	protected function recipe_instructions() {
		parent::recipe_instructions();

		$this->recipe->recipe_instructions = array_map(
			[ $this, 'strip_leading_numbers' ],
			$this->recipe->recipe_instructions
		);
	}
}
