<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Need to test yield more extensively.
 */
class PaulaDeenCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = [ './/img[@class="base-product-image"]', [ '@src' ] ];
		$this->paths['recipe_ingredient'] = [ './/*[@class="detail-box ingredients"]/ul/li', [ 'nodeValue' ] ];
		$this->paths['recipe_instructions'] = [ './/*[@class="detail-box preparation"]/p', [ 'nodeValue' ] ];
		$this->paths['recipe_yield'] = [ './/div[@class="recipe-info"]/div[4]/span[@class="data"]', [ 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}
}
