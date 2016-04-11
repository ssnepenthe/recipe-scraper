<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Calculate total time from prep and cook times
 *
 * They appear to have a JSON api if you send header 'Accept: application/json'.
 * Definitely worth exploring further...
 */
class BHGCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/*[@itemprop="thumbnail"]';
		$this->paths['name'][0] = './/h1[@itemprop="name"]';
	}
}
