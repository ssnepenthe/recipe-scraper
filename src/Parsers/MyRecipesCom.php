<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * Need to revisit times...
 */
class MyRecipesCom extends DataVocabularyOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['author'][0] = './/*[@class="field-author"]';
		$this->paths['publisher'][0] = './/*[@class="field-sponsor"]';
		$this->paths['recipe_instructions'][0] = './/*[@itemprop="instructions"]//p';
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
		parent::recipe_instructions();

		$this->recipe->recipe_instructions = array_map(
			[ $this, 'strip_leading_numbers' ],
			$this->recipe->recipe_instructions
		);
	}

	protected function total_time() {
		$time = $this->get_single_item( $this->paths['total_time'] );
		$this->recipe->total_time = $time ? DateInterval::createFromDateString( $time ) : null;
	}
}
