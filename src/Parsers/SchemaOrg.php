<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;
use DateTime;
use DOMText;
use SSNepenthe\RecipeParser\Schema\Recipe;
use SSNepenthe\Convenience\DOMDocument;
use SSNepenthe\Convenience\DOMXPath;
use SSNepenthe\RecipeParser\Contracts\ParserInterface;

class SchemaOrg implements ParserInterface {
	protected $dom;
	protected $paths = [
		'author'             => './/*[@itemprop="author"]',
		'cookTime'           => './/*[@itemprop="cookTime"]',
		'description'        => './/*[@itemprop="description"]',
		'image'              => './/*[@itemprop="image"]',
		'name'               => './/*[@itemprop="name"]',
		'prepTime'           => './/*[@itemprop="prepTime"]',
		'publisher'          => './/*[@itemprop="publisher"]',
		'recipeCategory'     => './/*[@itemprop="recipeCategory"]',
		'recipeIngredient'   => './/*[@itemprop="ingredients"]', // or recipeIngredient
		'recipeInstructions' => './/*[@itemprop="recipeInstructions"]',
		'recipeYield'        => './/*[@itemprop="recipeYield"]',
		'totalTime'          => './/*[@itemprop="totalTime"]',
		'url'                => [ './/*[@itemprop="url"]', './/*[@rel="canonical"]' ],
	];
	protected $recipe;
	protected $schema_root;
	protected $xpath;

	public function __construct( $html ) {
		$this->dom = new DOMDocument;
		$this->dom->loadHTML( $html );

		$this->recipe = new Recipe;

		$this->xpath = new DOMXPath( $this->dom );
	}

	/**
	 * @todo notes (not in spec), recipeCuisine, nutrition, review?
	 */
	public function parse() {
		$this->schema_root = $this->xpath->query( '//*[contains(@itemtype, "//schema.org/Recipe") or contains(@itemtype, "//schema.org/recipe")]' );

		if ( 0 === $this->schema_root->length ) {
			return;
		}

		$this->parse_author();
		$this->parse_cook_time();
		$this->parse_description();
		$this->parse_image();
		$this->parse_name();
		$this->parse_prep_time();
		$this->parse_publisher();
		$this->parse_recipe_categories();
		$this->parse_recipe_ingredients();
		$this->parse_recipe_instructions();
		$this->parse_recipe_yield();
		$this->parse_total_time();
		$this->parse_url();

		$this->calculate_total_time_if_not_set();

		return $this->recipe;
	}

	protected function parse_author() {
		// Look first within the root recipe node.
		$nodes = $this->xpath->query( $this->paths['author'], $this->schema_root->item( 0 ) );

		// Fall back to the document root if not found
		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['author'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_author( trim( $node->getAttribute( 'content' ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_author( trim( $node->nodeValue ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_cook_time() {
		$nodes = $this->xpath->query( $this->paths['cookTime'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['cookTime'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->hasAttribute( 'datetime' ) ) {
					$this->recipe->set_cook_time( new DateInterval( trim( $node->getAttribute( 'datetime' ) ) ) );
					break;
				}

				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_cook_time( new DateInterval( trim( $node->getAttribute( 'content' ) ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_cook_time( new DateInterval( trim( $node->nodeValue ) ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_description() {
		$nodes = $this->xpath->query( $this->paths['description'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['description'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				// Revisit this...
				// if ( $node->hasAttribute( 'content' ) ) {
				// 	$this->recipe->set_description( $node->getAttribute( 'content' ) );
				// }

				if ( $node->nodeValue ) {
					$this->recipe->set_description( trim( $node->nodeValue ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_image() {
		// Can also be an ImageObject...
		$nodes = $this->xpath->query( $this->paths['image'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['image'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				// Revisit this... check against allrecipes.com.
				// if ( $node->hasAttribute( 'content' ) ) {
				// 	$this->recipe->add_image( trim( $node->getAttribute( 'content' ) ) );
				// }

				if ( $node->hasAttribute( 'src' ) ) {
					$this->recipe->set_image( trim( $node->getAttribute( 'src' ) ) );
					break;
				}

				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_image( trim( $node->getAttribute( 'content' ) ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_name() {
		$nodes = $this->xpath->query( $this->paths['name'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['name'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_name( trim( $node->getAttribute( 'content' ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_name( trim( $node->nodeValue ) );
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
				if ( $node->hasAttribute( 'datetime' ) ) {
					$this->recipe->set_prep_time( new DateInterval( trim( $node->getAttribute( 'datetime' ) ) ) );
					break;
				}

				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_prep_time( new DateInterval( trim( $node->getAttribute( 'content' ) ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_prep_time( new DateInterval( trim( $node->nodeValue ) ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_publisher() {
		$nodes = $this->xpath->query( $this->paths['publisher'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['publisher'] );
		}

		if ( $nodes->length ) {
			foreach( $nodes as $node ) {
				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_publisher( trim( $node->getAttribute( 'content' ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_publisher( trim( $node->nodeValue ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_recipe_categories() {
		$nodes = $this->xpath->query( $this->paths['recipeCategory'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['recipeCategory'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$value = trim( $node->nodeValue );
					$value = strtolower( $value );

					$this->recipe->add_recipe_category( $value );
				}
			}

			unset( $node, $value );
		}

		unset( $nodes );
	}

	protected function parse_recipe_ingredients() {
		$nodes = $this->xpath->query( $this->paths['recipeIngredient'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['recipeIngredient'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$value = trim( $node->nodeValue );
					$value = $this->normalize_whitespace( $value );
					$value = $this->normalize_fractions( $value );

					$this->recipe->add_recipe_ingredient( $value );
				}
			}

			unset( $node, $value );
		}

		unset( $nodes );
	}

	protected function parse_recipe_instructions() {
		//Can also be an ItemList...
		$nodes = $this->xpath->query( $this->paths['recipeInstructions'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['recipeInstructions'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->nodeValue ) {
					$value = trim( $node->nodeValue );
					$value = $this->normalize_whitespace( $value );
					$value = $this->strip_leading_numbers( $value );

					$this->recipe->add_recipe_instruction( $value );
				}
			}

			unset( $node, $value );
		}

		unset( $nodes );
	}

	protected function parse_recipe_yield() {
		$nodes = $this->xpath->query( $this->paths['recipeYield'], $this->schema_root->item( 0 ) );

		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $this->paths['recipeYield'] );
		}

		if ( $nodes->length ) {
			foreach ( $nodes as $node ) {
				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_recipe_yield(
						$this->normalize_yield(
							trim( $node->getAttribute( 'content' ) )
						)
					);
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_recipe_yield( $this->normalize_yield(
						trim( $node->nodeValue )
					) );
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
				if ( $node->hasAttribute( 'datetime' ) ) {
					$this->recipe->set_total_time( new DateInterval( trim( $node->getAttribute( 'datetime' ) ) ) );
					break;
				}

				if ( $node->hasAttribute( 'content' ) ) {
					$this->recipe->set_total_time( new DateInterval( trim( $node->getAttribute( 'content' ) ) ) );
					break;
				}

				if ( $node->nodeValue ) {
					$this->recipe->set_total_time( new DateInterval( trim( $node->nodeValue ) ) );
					break;
				}
			}

			unset( $node );
		}

		unset( $nodes );
	}

	protected function parse_url() {
		// Alternative - meta:property = og:url
		foreach ( $this->paths['url'] as $path ) {
			$nodes = $this->xpath->query( $path, $this->schema_root->item( 0 ) );

			if ( ! $nodes->length ) {
				$nodes = $this->xpath->query( $path );
			}

			if ( $nodes->length ) {
				foreach( $nodes as $node ) {
					if ( $node->hasAttribute( 'href' ) ) {
						$this->recipe->set_url( trim( $node->getAttribute( 'href' ) ) );
						break;
					}
				}

				unset( $node );
			}

			unset( $nodes );
		}
	}

	protected function calculate_total_time_if_not_set() {
		if ( ! is_null( $this->recipe->total_time ) ) {
			return;
		}

		if ( ! is_null( $this->recipe->prep_time ) && ! is_null( $this->recipe->cook_time ) ) {
			$now = new DateTime( 'now' );
			$later = new DateTime( 'now' );

			$later = $later->add( $this->recipe->cook_time );
			$later = $later->add( $this->recipe->prep_time );

			$this->recipe->set_total_time( $later->diff( $now ) );

			unset( $now, $later );
		}
	}

	protected function normalize_fractions( $value ) {
		$value = str_replace(
			[ '⅛', '¼', '⅓', '⅜', '½', '⅝', '⅔', '¾', '⅞' ],
			[ '1/8', '1/4', '1/3', '3/8', '1/2', '5/8', '2/3', '3/4', '7/8' ],
			$value
		);

		return $value;
	}

	protected function normalize_newlines( $value ) {
		return preg_replace(
			[ '/\r\n|\r|\n/', '/\n\s+/' ],
			PHP_EOL,
			$value
		);
	}

	protected function normalize_whitespace( $value ) {
		return preg_replace( '/\s{2,}/', ' ', $value );
	}

	protected function normalize_yield( $value ) {
		$value = strtolower( $value );

		$value = str_replace( [ 'yield: ', 'serves ' ], '', $value );

		if ( false === strpos( $value, 'servings' ) ) {
			$value .= ' servings';
		}

		return $value;
	}

	protected function strip_leading_numbers( $value ) {
		return preg_replace( '/^\d+\s+/', '', $value );
	}
}
