<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Make sure to use meta tag for image so we don't have to fix relative urls.
 *
 * Description **may** be coming from reviews...
 *
 * Author may be coming from reviews as well...
 */
class TasteOfHomeCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/meta[@itemprop="image"]';
		$this->paths['recipe_yield'][0] = './/*[@itemprop="recipeyield"]';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
	}
}
