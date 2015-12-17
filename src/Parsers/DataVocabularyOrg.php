<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * I'm looking at you, myrecipes.com...
 */
class DataVocabularyOrg extends BaseParser {
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
				'.//*[@itemprop="summary"]',
				[ 'nodeValue' ],
			],
			'image' => [
				'.//*[@itemprop="photo"]',
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
			'publisher' => [ // No publisher for this type, just re-use author.
				'.//*[@itemprop="author"]',
				[ '@content', 'nodeValue' ],
			],
			'recipe_category' => [
				'.//*[@itemprop="recipeType"]',
				[ 'nodeValue' ],
			],
			'recipe_ingredient' => [
				'.//*[@itemprop="ingredient"]',
				[ 'nodeValue' ],
			],
			'recipe_instructions' => [
				'.//*[@itemprop="instructions"]',
				[ 'nodeValue' ],
			],
			'recipe_yield' => [
				'.//*[@itemprop="yield"]',
				[ '@content', 'nodeValue' ],
			],
			'total_time' => [
				'.//*[@itemprop="totalTime"]',
				[ '@datetime', '@content', 'nodeValue' ],
			],
			'url' => [
				'.//*[@rel="canonical"]', // No URL for this type, use canonical link.
				[ '@href', '@content', 'nodeValue' ],
			],
		];
	}

	protected function set_root_node() {
		$schema_nodes = $this->xpath->query(
			'//*[contains(@itemtype, "http://data-vocabulary.org/Recipe") or contains(@itemtype, "http://data-vocabulary.org/recipe")]'
		);

		if ( 0 === $schema_nodes->length ) {
			throw new RuntimeException( 'This page does not appear to implement the schema.org recipe schema.' );
		}

		$this->root_node = $schema_nodes->item( 0 );
		unset( $schema_nodes );
	}
}
