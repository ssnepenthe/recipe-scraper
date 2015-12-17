<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DOMText;

/**
 * times between 1 and 2 hours are incorrect
 *
 * what about notes?
 */
class FarmFlavorCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['recipe_category'][0] = './/p[@class="postmetadata"]/a';
	}
}
