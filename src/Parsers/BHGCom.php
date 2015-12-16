<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Calculate total time from prep and cook times
 *
 */
class BHGCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = './/*[@itemprop="thumbnail"]';
		$this->paths['name'] = './/h1[@itemprop="name"]';
	}
	protected function parse_recipe_instructions() {
		$nodes = $this->xpath->query( $this->paths['recipeInstructions'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['recipeInstructions'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$value = trim( $node->nodeValue );
					$value = $this->normalize_newlines( $value );
					$value = $this->normalize_whitespace( $value );

					$value = array_map( 'trim', explode( "\n", $value ) );

					foreach ( $value as $instruction ) {
						$this->recipe->add_recipe_instruction( $instruction );
					}
				}
			}

			unset( $node, $value, $instruction );
		}

		unset( $nodes );
	}
}
