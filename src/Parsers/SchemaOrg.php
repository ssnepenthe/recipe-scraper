<?php

namespace SSNepenthe\RecipeParser\Parsers;

use RuntimeException;

class SchemaOrg extends BaseParser {
	protected function set_paths() {
		$this->paths = [
			'author' => [
				'.//*[@itemprop="author"]',
				[ '@content', 'nodeValue' ],
			],
			'cook_time' => [
				'.//*[@itemprop="cookTime"]',
				[ '@datetime', '@content', 'nodeValue' ],
			],
			'description' => [
				'.//*[@itemprop="description"]',
				[ 'nodeValue' ],
			],
			'image' => [
				'.//*[@itemprop="image"]',
				[ '@src', '@content' ],
			],
			'name' => [
				'.//*[@itemprop="name"]',
				[ '@content', 'nodeValue' ],
			],
			'prep_time' => [
				'.//*[@itemprop="prepTime"]',
				[ '@datetime', '@content', 'nodeValue' ],
			],
			'publisher' => [
				'.//*[@itemprop="publisher"]',
				[ '@content', 'nodeValue' ],
			],
			'recipe_category' => [
				'.//*[@itemprop="recipeCategory"]',
				[ 'nodeValue' ],
			],
			'recipe_ingredient' => [
				'.//*[@itemprop="ingredients"]',
				[ 'nodeValue' ],
			],
			'recipe_instructions' => [
				'.//*[@itemprop="recipeInstructions"]//li',
				[ 'nodeValue' ],
			],
			'recipe_yield' => [
				'.//*[@itemprop="recipeYield"]',
				[ '@content', 'nodeValue' ],
			],
			'total_time' => [
				'.//*[@itemprop="totalTime"]',
				[ '@datetime', '@content', 'nodeValue' ],
			],
			'url' => [
				'.//*[@itemprop="url"]',
				[ '@href', '@content', 'nodeValue' ],
			],
		];
	}

	protected function set_root_node() {
		$schema_nodes = $this->xpath->query(
			'//*[contains(@itemtype, "http://schema.org/Recipe") or contains(@itemtype, "http://schema.org/recipe")]'
		);

		if ( 0 === $schema_nodes->length ) {
			throw new RuntimeException( 'This page does not appear to implement the schema.org recipe schema.' );
		}

		$this->root_node = $schema_nodes->item( 0 );
		unset( $schema_nodes );
	}
}
