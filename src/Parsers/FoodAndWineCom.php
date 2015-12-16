<?php

namespace SSNepenthe\RecipeParser\Parsers;

class FoodAndWineCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['name'] = './/h1[@itemprop="name"]';
		$this->paths['recipeCategory'] = './/span[@class="tag-set__tag__text"]';
	}
}
