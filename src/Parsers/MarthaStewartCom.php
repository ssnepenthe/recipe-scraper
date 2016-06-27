<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Also has cooks notes if we want them (http://www.marthastewart.com/313086/buttermilk-chicken-caesar-salad).
 *       Need a lot more testing on recipeYield - might grap cook/prep time.
 */
class MarthaStewartCom extends SchemaOrg
{
	protected function configure()
	{
		parent::configure();

		$this->config['image']['selector'] = '[itemprop="image"] + noscript>img';
		$this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
		$this->config['recipeInstructions']['selector'] = '.directions-item-text';
		$this->config['recipeYield']['selector'] = '.mslo-credits:last-child';
		$this->config['url']['selector'] = '[rel="canonical"]';
	}
}
