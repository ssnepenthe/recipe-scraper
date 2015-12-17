<?php

namespace SSNepenthe\RecipeParser\Parsers;

class FoodAndWineCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['description'] = [ './/header[contains(@class, "recipe__header")]/p[2]', [ 'nodeValue' ] ];
		$this->paths['name'] = [ './/h1[@itemprop="name"]', [ 'nodeValue' ] ];
		$this->paths['recipe_category'] = [ './/span[@class="tag-set__tag__text"]', [ 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}
}
