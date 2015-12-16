<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;

/**
 * As of 2015/12/16 this site uses improperly formatted interval strings.
 * Rather than trying to detect and fix on the fly we are using the date string.
 */
class MarthaStewartCom extends SchemaOrg {
	public function __construct( $html ) {
		parent::__construct( $html );

		$this->paths['image'] = './/*[@itemprop="image"]/following-sibling::noscript/img';
		$this->paths['cookTime'] = './/*[@itemprop="cookTime"]/following-sibling::time';
		$this->paths['prepTime'] = './/*[@itemprop="prepTime"]/following-sibling::time';
		$this->paths['recipeInstructions'] = './/p[@class="directions-item-text"]';
		$this->paths['totalTime'] = './/*[@itemprop="totalTime"]/following-sibling::time';
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
