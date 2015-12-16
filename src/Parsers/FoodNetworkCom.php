<?php

namespace SSNepenthe\RecipeParser\Parsers;

class FoodNetworkCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = './/div[@class="recipe"]//img[@itemprop="image"]';
		$this->paths['recipeInstructions'] = './/*[@itemprop="recipeInstructions"]/p';
	}
}
