<?php

namespace SSNepenthe\RecipeParser\Parsers;

class AllRecipesCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['description'][0] = './/div[@itemprop="description"]';
	}
}
