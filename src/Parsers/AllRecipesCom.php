<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Can potentially get categories from breadcrumbs or related categories in
 * sidebar.
 */
class AllRecipesCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['description'][0] = './/div[@itemprop="description"]';
	}
}
