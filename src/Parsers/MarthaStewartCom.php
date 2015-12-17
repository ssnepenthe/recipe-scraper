<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * Getting some wacky stuff from itemprop="url" so use rel="canonical".
 *
 * As of 2015/12/16 this site uses improperly formatted interval strings.
 * Rather than trying to detect and fix on the fly we are using the date string.
 *
 * Notes? see http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad
 *
 * Gaaaaaaaaahhhhhh! can't get yield to work on http://www.marthastewart.com/330196/lil-smoky-cheese-ball
 *
 * Seriously... what the hell, Martha?!?!
 */
class MarthaStewartCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = [ './/*[@itemprop="image"]/following-sibling::noscript/img', [ '@src' ] ];
		$this->paths['cook_time'] = [ './/*[@itemprop="cookTime"]/following-sibling::time', [ 'nodeValue' ] ];
		$this->paths['prep_time'] = [ './/*[@itemprop="prepTime"]/following-sibling::time', [ 'nodeValue' ] ];
		$this->paths['recipe_instructions'] = [ './/p[@class="directions-item-text"]', [ 'nodeValue' ] ];
		$this->paths['recipe_yield'] = [ './/*[contains(@class, "top-intro-times")]/li[last()]', [ 'nodeValue' ] ];
		$this->paths['total_time'] = [ './/*[@itemprop="totalTime"]/following-sibling::time', [ 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}

	protected function cook_time() {
		$time = $this->get_single_item( $this->paths['cook_time'] );
		$this->recipe->cook_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}

	protected function prep_time() {
		$time = $this->get_single_item( $this->paths['prep_time'] );
		$this->recipe->prep_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}

	protected function total_time() {
		$time = $this->get_single_item( $this->paths['total_time'] );
		$this->recipe->total_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}
}
