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
	protected $paths = [
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

	protected $dom;
	protected $recipe;
	protected $schema_root;
	protected $xpath;

	public function __construct( $html ) {
		$this->dom = new DOMDocument;
		$this->dom->loadHTML( $html );

		$this->xpath = new DOMXPath( $this->dom );

		$schema_nodes = $this->xpath->query(
			'//*[contains(@itemtype, "http://schema.org/Recipe") or contains(@itemtype, "http://schema.org/recipe")]'
		);

		if ( 0 === $schema_nodes->length ) {
			throw new RuntimeException( 'This page does not appear to implement the schema.org recipe schema.' );
		}

		$this->schema_root = $schema_nodes->item( 0 );
		unset( $schema_nodes );

		$this->recipe = new Recipe;
	}

	/**
	 * @todo notes (not in spec), recipeCuisine, nutrition, review?
	 */
	public function parse() {
		$this->author();
		$this->cook_time();
		$this->description();
		$this->image();
		$this->name();
		$this->prep_time();
		$this->publisher();
		$this->recipe_categories();
		$this->recipe_ingredients();
		$this->recipe_instructions();
		$this->recipe_yield();
		$this->total_time();
		$this->url();

		// $this->calculate_total_time_if_not_set();

		return $this->recipe;
	}

	protected function author() {
		$author = $this->get_formatted_single_item( $this->paths['author'] );
		$author = $this->normalize_author( $author );

		$this->recipe->author = $author;
	}

	protected function cook_time() {
		$time = $this->get_single_item( $this->paths['cook_time'] );
		$this->recipe->cook_time = $time ? new DateInterval( $time ) : null;
	}

	protected function description() {
		$this->recipe->description = $this->get_formatted_single_item( $this->paths['description'] );
	}

	protected function image() {
		$this->recipe->image = $this->get_formatted_single_item( $this->paths['image'] );
	}

	protected function name() {
		$this->recipe->name = $this->get_formatted_single_item( $this->paths['name'] );
	}

	protected function prep_time() {
		$time = $this->get_formatted_single_item( $this->paths['prep_time'] );
		$this->recipe->prep_time = $time ? new DateInterval( $time ) : null;
	}

	protected function publisher() {
		$this->recipe->publisher = $this->get_formatted_single_item( $this->paths['publisher'] );
	}

	protected function recipe_categories() {
		$this->recipe->recipe_categories = $this->get_item_list( $this->paths['recipe_category'] );
	}

	protected function recipe_ingredients() {
		$ingredients = $this->get_item_list( $this->paths['recipe_ingredient'] );
		$ingredients = array_map( [ $this, 'normalize_fractions' ], $ingredients );

		$this->recipe->recipe_ingredients = $ingredients;
	}

	protected function recipe_instructions() {
		$instructions = $this->get_item_list( $this->paths['recipe_instructions'] );
		$instructions = array_map( 'trim', $instructions );
		$instructions = array_filter( $instructions );

		$this->recipe->recipe_instructions = $instructions;
	}

	protected function recipe_yield() {
		$this->recipe->recipe_yield = $this->normalize_yield(
			$this->get_formatted_single_item( $this->paths['recipe_yield'] )
		);
	}

	protected function total_time() {
		$time = $this->get_formatted_single_item( $this->paths['total_time'] );
		$this->recipe->total_time = $time ? new DateInterval( $time ) : null;
	}

	protected function url() {
		$this->recipe->url = $this->get_formatted_single_item( $this->paths['url'] );
	}

	protected function get_formatted_single_item( array $paths ) {
		$value = $this->get_single_item( $paths );

		if ( ! is_null( $value ) ) {
			$value = $this->format_as_single_line( $value );
		}

		return $value;
	}

	protected function get_single_item( array $paths ) {
		$nodes = $this->xpath->query( $paths[0], $this->schema_root );

		// Fall back to full document if item not found within schema root.
		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $paths[0] );
		}

		// Bail if we still haven't found any nodes.
		if ( ! $nodes->length ) {
			return null;
		}

		$node = $nodes->item( 0 );
		$value = null;

		foreach ( $paths[1] as $location ) {
			if ( '@' === substr( $location, 0, 1 ) ) {
				// Item attribute reference.
				$location = str_replace( '@', '', $location );

				if ( $node->hasAttribute( $location ) ) {
					$value = trim( $node->getAttribute( $location ) );
					break;
				}
			} else {
				// Object property reference.
				if ( $node->{$location} ) {
					$value = trim( $node->{$location} );
					break;
				}
			}
		}

		unset( $nodes, $node, $location );

		return $value;
	}

	protected function get_item_list( array $paths ) {
		$nodes = $this->xpath->query( $paths[0], $this->schema_root );

		// Fall back to full document if item not found within schema root.
		if ( ! $nodes->length ) {
			$nodes = $this->xpath->query( $paths[0] );
		}

		// Bail if we still haven't found any nodes.
		if ( ! $nodes->length ) {
			return null;
		}

		$value = [];

		foreach ( $nodes as $node ) {
			foreach ( $paths[1] as $location ) {
				if ( '@' === substr( $location, 0, 1 ) ) {
					// Item attribute reference.
					$location = str_replace( '@', '', $location );

					if ( $node->hasAttribute( $location ) ) {
						$value[] = trim( $node->getAttribute( $location ) );
					}
				} else {
					// Object property reference.
					if ( $node->{$location} ) {
						$value[] = trim( $node->{$location} );
					}
				}
			}
		}

		if ( ! empty( $value ) ) {
			$value = array_map( [ $this, 'format_as_single_line' ], $value );
		}

		unset( $nodes, $node, $location );

		return $value;
	}

	protected function get_list_from_single_item( array $paths ) {
		$value = $this->get_single_item( $paths );

		if ( ! is_null( $value ) ) {
			$value = $this->normalize_whitespace( $value );
			$value = explode( PHP_EOL, $value );
		}

		return $value;
	}

	protected function format_as_single_line( $value ) {
		$value = $this->normalize_whitespace( $value );
		$value = str_replace( PHP_EOL, ' ', $value );

		return $value;
	}

	protected function normalize_author( $value ) {
		$value = str_replace( [ 'By ', 'by ' ], '', $value );

		return $value;
	}

	protected function normalize_eol( $value ) {
		return preg_replace(
			[ '/\r\n|\r|\n/', '/\n\s+/' ],
			PHP_EOL,
			$value
		);
	}

	protected function normalize_fractions( $value ) {
		// First add a space if one doesn't exist.
		if ( preg_match( '/⅛|¼|⅓|⅜|½|⅝|⅔|¾|⅞/', $value ) ) {
			$value = preg_replace( '/(\d+)([⅛|¼|⅓|⅜|½|⅝|⅔|¾|⅞])/', '$1 $2', $value  );
		}

		// Then replace the fraction.
		$value = str_replace(
			[ '⅛', '¼', '⅓', '⅜', '½', '⅝', '⅔', '¾', '⅞' ],
			[ '1/8', '1/4', '1/3', '3/8', '1/2', '5/8', '2/3', '3/4', '7/8' ],
			$value
		);

		return $value;
	}

	protected function normalize_spaces( $value ) {
		$value = str_replace( [ '&nbsp;', '&#160;' ], ' ', $value );
		$value = preg_replace( '/\xC2\xA0/', ' ', $value );
		$value = preg_replace( '/\s{2,}/', ' ', $value );

		return $value;
	}

	protected function normalize_numbers( $value ) {
		$words = [
			'one',
			'two',
			'three',
			'four',
			'five',
			'six',
			'seven',
			'eight',
			'nine',
			'ten',
			'eleven',
			'twelve',
			'thirteen',
			'fourteen',
			'fifteen',
			'sixteen',
			'seventeen',
			'eighteen',
			'nineteen',
			'twenty',
		];

		$digits = [
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9',
			'10',
			'11',
			'12',
			'13',
			'14',
			'15',
			'16',
			'17',
			'18',
			'19',
			'20',
		];

		return str_replace( $words, $digits, $value );
	}

	protected function normalize_whitespace( $value ) {
		$value = $this->normalize_eol( $value );
		$value = $this->normalize_spaces( $value );

		return $value;
	}

	protected function normalize_yield( $value ) {
		$value = strtolower( $value );
		$value = $this->normalize_numbers( $value );
		$value = preg_replace( '/^(yield|serving|serve|make)s?:?\s*/', '', $value );

		if ( preg_match( '/\d$/', $value ) && false === strpos( $value, 'servings' ) ) {
			$value .= ' servings';
		}

		return $value;
	}

	protected function strip_leading_numbers( $value ) {
		return preg_replace( '/^\d+\s+/', '', $value );
	}

	// protected function calculate_total_time_if_not_set() {
	// 	if ( ! is_null( $this->recipe->total_time ) ) {
	// 		return;
	// 	}

	// 	if ( ! is_null( $this->recipe->prep_time ) && ! is_null( $this->recipe->cook_time ) ) {
	// 		$now = new DateTime( 'now' );
	// 		$later = new DateTime( 'now' );

	// 		$later = $later->add( $this->recipe->cook_time );
	// 		$later = $later->add( $this->recipe->prep_time );

	// 		$this->recipe->set_total_time( $later->diff( $now ) );

	// 		unset( $now, $later );
	// 	}
	// }
}
