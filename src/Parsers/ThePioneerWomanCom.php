<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * @todo think about handling ingredient and instruction groups
 *       think about adding notes
 */
class ThePioneerWomanCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = './/div[@class="recipe-summary-thumbnail"]/img';
	}
	protected function parse_cook_time() {
		$nodes = $this->xpath->query( $this->paths['cookTime'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['cookTime'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$this->recipe->set_cook_time( DateInterval::createFromDateString( trim( $node->nodeValue ) ) );

					unset( $nodes, $node );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_prep_time() {
		$nodes = $this->xpath->query( $this->paths['prepTime'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['prepTime'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$this->recipe->set_prep_time( DateInterval::createFromDateString( trim( $node->nodeValue ) ) );

					unset( $nodes, $node );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_recipe_instructions() {
		$nodes = $this->xpath->query( $this->paths['recipeInstructions'][0], $this->schema_root->item( 0 ) );

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( ! $node->nodeValue ) {
					continue;
				}

				$value = trim( $node->nodeValue );
				$value = $this->normalize_newlines( $value );
				$value = $this->normalize_whitespace( $value );
				$value = array_filter( explode( PHP_EOL, $value ) );

				foreach ( $value as $instruction ) {
					$this->recipe->add_recipe_instruction( $instruction );
				}
			}

			unset( $node, $value );
		}

		unset( $nodes );
	}

	protected function parse_total_time() {
		$nodes = $this->xpath->query( $this->paths['totalTime'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['totalTime'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$this->recipe->set_total_time( DateInterval::createFromDateString( trim( $node->nodeValue ) ) );

					unset( $nodes, $node );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}
}
