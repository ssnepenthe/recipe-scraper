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
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/*[@itemprop="image"]/following-sibling::noscript/img';
		$this->paths['cook_time'][0] = './/*[@itemprop="cookTime"]/following-sibling::time';
		$this->paths['prep_time'][0] = './/*[@itemprop="prepTime"]/following-sibling::time';
		$this->paths['recipe_category'][0] = './/*[@class="related-topic-item-title"]';
		$this->paths['recipe_instructions'][0] = './/p[@class="directions-item-text"]';
		$this->paths['recipe_yield'][0] = './/*[contains(@class, "top-intro-times")]/li[last()]';
		$this->paths['total_time'][0] = './/*[@itemprop="totalTime"]/following-sibling::time';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
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
