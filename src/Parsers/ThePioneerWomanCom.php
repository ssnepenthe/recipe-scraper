<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * think about handling ingredient and instruction groups
 *
 * think about adding notes
 */
class ThePioneerWomanCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/div[@class="recipe-summary-thumbnail"]/img';
		$this->paths['recipe_instructions'][0] = './/*[@itemprop="recipeInstructions"]';
		$this->paths['url'][0] = './/link[@rel="canonical"]';
	}

	protected function cook_time() {
		$time = $this->get_single_item( $this->paths['cook_time'] );
		$this->recipe->cook_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}

	protected function prep_time() {
		$time = $this->get_single_item( $this->paths['prep_time'] );
		$this->recipe->prep_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}

	protected function recipe_instructions() {
		$this->recipe->recipe_instructions = $this->get_list_from_single_item( $this->paths['recipe_instructions'] );
	}

	protected function total_time() {
		$time = $this->get_single_item( $this->paths['total_time'] );
		$this->recipe->total_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}
}
