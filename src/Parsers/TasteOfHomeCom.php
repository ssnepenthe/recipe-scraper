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
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = [ './/meta[@itemprop="image"]', [ '@content' ] ];
		$this->paths['recipe_yield'] = [ './/*[@itemprop="recipeyield"]', [ '@content', 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}
}
