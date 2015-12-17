<?php

namespace SSNepenthe\RecipeParser\Parsers;

use DateInterval;
use RuntimeException;
use SSNepenthe\Convenience\DOMDocument;
use SSNepenthe\Convenience\DOMXPath;
use SSNepenthe\RecipeParser\Contracts\ParserInterface;
use SSNepenthe\RecipeParser\Schema\Recipe;

abstract class BaseParser implements ParserInterface {
	protected $paths = [];
	protected $dom;
	protected $recipe;
	protected $root_node;
	protected $xpath;

	public function __construct( $html ) {
		$this->dom = new DOMDocument;
		$this->dom->loadHTML( $html );

		$this->xpath = new DOMXPath( $this->dom );

		$this->recipe = new Recipe;

		// Child classes must define the root node.
		$this->set_root_node();
		$this->set_paths();

		// Make sure all required paths are set.
		$this->verify_all_paths_set();
	}

	abstract protected function set_root_node();

	abstract protected function set_paths();

	protected function verify_all_paths_set() {
		$required_keys = [
			'author',
			'cook_time',
			'description',
			'image',
			'name',
			'prep_time',
			'publisher',
			'recipe_category',
			'recipe_ingredient',
			'recipe_instructions',
			'recipe_yield',
			'total_time',
			'url',
		];

		if ( ! empty( $missing = array_diff( $required_keys, array_keys( $this->paths ) ) ) ) {
			throw new RuntimeException( sprintf(
				'The following keys must be defined in %s: %s',
				__CLASS__,
				implode( ', ', $missing )
			) );
		}

		foreach ( $required_keys as $key ) {
			if ( ! is_array( $this->paths[ $key ] ) && 2 !== count( $this->paths[ $key ] ) ) {
				throw new RuntimeException( sprintf(
					'Please supply an array as the value for %s',
					$key
				) );
			}

			if ( ! is_string( $this->paths[ $key ][0] ) ) {
				throw new RuntimeException( sprintf(
					'The value given at $paths[\'%s\'][0] must be a string',
					$key
				) );
			}

			if ( ! is_array( $this->paths[ $key ][1] ) ) {
				throw new RuntimeException( sprintf(
					'The value given at $paths[\'%s\'][1] must be an array',
					$key
				) );
			}
		}
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
		$publisher = $this->get_formatted_single_item( $this->paths['publisher'] );
		$publisher = $this->normalize_author( $publisher );

		$this->recipe->publisher = $publisher;
	}

	protected function recipe_categories() {
		$categories = $this->get_item_list( $this->paths['recipe_category'] );
		$categories = array_map( 'strtolower', $categories );

		$this->recipe->recipe_categories = $categories;
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
		$nodes = $this->xpath->query( $paths[0], $this->root_node );

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
		$nodes = $this->xpath->query( $paths[0], $this->root_node );

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
