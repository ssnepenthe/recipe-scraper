<?php

namespace SSNepenthe\RecipeParser\Parsers;

class DelishCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = './/div[@class="embedded-image--inner"]/img';
	}

	public function parse_image() {
		$nodes = $this->xpath->query( $this->paths['image'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['image'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->hasAttribute( 'data-src' ) ) {
					$this->recipe->set_image( trim( $node->getAttribute( 'data-src' ) ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}
}
