<?php

namespace SSNepenthe\RecipeParser\Schema;

class Recipe {
	protected $author;
	protected $cook_time;
	protected $description;
	protected $image;
	protected $name;
	protected $prep_time;
	protected $publisher;
	protected $recipe_categories = [];
	protected $recipe_ingredients = [];
	protected $recipe_instructions = [];
	protected $recipe_yield;
	protected $total_time;
	protected $url;

	public function __get( $key ) {
		if ( isset( $this->{$key} ) && ! empty( $this->{$key} ) ) {
			return $this->{$key};
		}

		return null;
	}

	public function recipe_yield() {
		return $this->recipe_yield;
	}

	public function add_recipe_category( $category ) {
		$this->recipe_categories[] = $category;
	}

	public function add_recipe_ingredient( $ingredient ) {
		$this->recipe_ingredients[] = $ingredient;
	}

	public function add_recipe_instruction( $instruction ) {
		$this->recipe_instructions[] = $instruction;
	}

	public function set_author( $author ) {
		$this->author = $author;
	}

	public function set_cook_time( $cook_time ) {
		$this->cook_time = $cook_time;
	}

	public function set_description( $description ) {
		$this->description = $description;
	}

	public function set_image( $image ) {
		$this->image = $image;
	}

	public function set_name( $name ) {
		$this->name = $name;
	}

	public function set_prep_time( $prep_time ) {
		$this->prep_time = $prep_time;
	}

	public function set_publisher( $publisher ) {
		$this->publisher = $publisher;
	}

	public function set_recipe_yield( $recipe_yield ) {
		$this->recipe_yield = $recipe_yield;
	}

	public function set_total_time( $total_time ) {
		$this->total_time = $total_time;
	}

	public function set_url( $url ) {
		$this->url = $url;
	}
}
