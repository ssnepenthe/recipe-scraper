<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * Need to test yield more extensively.
 */
class PaulaDeenCom extends SchemaOrg {
	protected function set_paths() {
		parent::set_paths();

		$this->paths['image'][0] = './/img[@class="base-product-image"]';
		$this->paths['recipe_ingredient'][0] = './/*[@class="detail-box ingredients"]/ul/li';
		$this->paths['recipe_instructions'][0] = './/*[@class="detail-box preparation"]/p';
		$this->paths['recipe_yield'][0] = './/div[@class="recipe-info"]/div[4]/span[@class="data"]';
		$this->paths['url'][0] = './/*[@rel="canonical"]';
	}
}
