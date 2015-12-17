<?php

namespace SSNepenthe\RecipeParser\Parsers;

class FoodAndWineCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['description'][0] = './/header[contains(@class, "recipe__header")]/p[2]';
		$this->paths['name'][0] = './/h1[@itemprop="name"]';
		$this->paths['recipe_category'][0] = './/span[@class="tag-set__tag__text"]';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
	}
}
