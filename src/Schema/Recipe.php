<?php

namespace SSNepenthe\RecipeParser\Schema;

class Recipe {
	protected $attributes = [];

	public function __construct() {
		$keys = [
			'author',
			'cook_time',
			'description',
			'image',
			'name',
			'prep_time',
			'publisher',
			'recipe_categories',
			'recipe_ingredients',
			'recipe_instructions',
			'recipe_yield',
			'total_time',
			'url',
		];

		foreach ( $keys as $key ) {
			$this->attributes[ $key ] = null;
		}
	}

	public function __get( $key ) {
		if ( array_key_exists( $key, $this->attributes ) ) {
			return $this->attributes[ $key ];
		}

		return null;
	}

	public function __set( $key, $value ) {
		if ( array_key_exists( $key, $this->attributes ) ) {
			$this->attributes[ $key ] = $value;
		}
	}
}
