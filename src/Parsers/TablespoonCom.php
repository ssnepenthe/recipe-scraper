<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Prep time is accessible via a javascript object.
 * image: would rather use @class="recipePartRecipeImage" for bigger image but is inconsistent.
 */
class TablespoonCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['recipe_category'] = [ './/*[@class="tags"]/ul/li/a', [ 'nodeValue' ] ];
		$this->paths['recipe_instructions'] = [ './/*[@itemprop="recipeInstructions"]/span[@class="recipePartStepDescription"]', [ 'nodeValue' ] ];
		$this->paths['url'] = [ './/*[@rel="canonical"]', [ '@href' ] ];
	}
}
