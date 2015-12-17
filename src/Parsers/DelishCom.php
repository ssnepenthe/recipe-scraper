<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Description needs more thorough testing.
 */
class DelishCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['description'] = [ './/div[@class="recipe-page--body-content"]/p', [ 'nodeValue' ] ];
		$this->paths['image'] = [ './/div[@class="embedded-image--inner"]/img', [ '@data-src' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}
}
