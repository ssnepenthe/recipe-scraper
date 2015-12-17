<?php

namespace SSNepenthe\RecipeParser\Parsers;

class AllRecipesCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['description'] = [ './/div[@itemprop="description"]', [ 'nodeValue' ] ];
	}
}
