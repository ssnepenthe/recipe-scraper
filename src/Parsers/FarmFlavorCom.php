<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DOMText;

/**
 * @todo times between 1 and 2 hours are incorrect
 *       think about notes
 */
class FarmFlavorCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipe_category'] = [ './/p[@class="postmetadata"]/a', [ 'nodeValue' ] ];
	}
}
