<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Calculate total time from prep and cook times
 */
class BHGCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = [ './/*[@itemprop="thumbnail"]', [ '@src' ] ];
		$this->paths['name'] = [ './/h1[@itemprop="name"]', [ 'nodeValue' ] ];
	}
}
