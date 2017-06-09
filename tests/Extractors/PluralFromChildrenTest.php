<?php

namespace RecipeScraperTests\Extractors;

use PHPUnit\Framework\TestCase;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Extractors\PluralFromChildren;

class PluralFromChildrenTest extends TestCase
{
	use UsesTestData;

	protected $crawler;
	protected $extractor;

	public function setUp()
	{
		$html = file_get_contents($this->getHtmlDataFilePath(
			'spryliving.com/recipes-baked-caprese-chicken'
		));

		$this->crawler = new Crawler(
			$html,
			'http://spryliving.com/recipes/baked-caprese-chicken/'
		);
		$this->extractor = new PluralFromChildren;
	}

	public function tearDown()
	{
		$this->crawler = null;
		$this->extractor = null;
	}

	/** @test */
	function it_returns_null_if_selector_provides_empty_node_list()
	{
		$this->assertNull($this->extractor->extract($this->crawler, '.fake'));
	}

	/** @test */
	function it_can_extract_text_value_from_a_node_lists_children()
	{
		$this->assertEquals(
			[
				'1 1/2 pounds boneless, skinless chicken breasts',
				'1/2 teaspoon salt',
				'1/2 teaspoon pepper',
				'3 large Roma tomatoes, sliced',
				'1 (1-oz) pkg fresh basil, thinly sliced (or use leaves whole)',
				'1 (8-oz) ball fresh mozzarella cheese, thinly sliced (or use block mozzarella)',
				'2 tablespoons olive oil',
				'3 tablespoons balsamic vinegar',
				'3/4 cup uncooked polenta',
				'1/2 teaspoon salt, divided',
				'1/2 teaspoon pepper, divided',
				'1/4 cup freshly grated Parmesan cheese',
				'2 pounds fresh green beans, trimmed',
				'1 tablespoon olive oil',
				'1 tablespoon fresh lemon juice',
			],
			$this->extractor->extract($this->crawler, '[itemprop="ingredients"]')
		);
	}

	/** @test */
	function it_can_extract_an_arbitrary_attribute_from_a_node_lists_children()
	{
		$this->assertEquals(
			['menu-14 menu-15 menu-52 menu-12'],
			$this->extractor->extract($this->crawler, '.main.no-bullet', ['id'])
		);
	}

	/** @test */
	function it_extracts_the_first_available_attribute_from_provided_list()
	{
		// Span children have class="type", strong children have no class.
		$this->assertEquals(
			[
				'1 1/2 type boneless, skinless chicken breasts',
				'1/2 type salt',
				'1/2 type pepper',
				'3 type Roma tomatoes, sliced',
				'1 type (1-oz) pkg fresh basil, thinly sliced (or use leaves whole)',
				'1 type (8-oz) ball fresh mozzarella cheese, thinly sliced (or use block mozzarella)',
				'2 type olive oil',
				'3 type balsamic vinegar',
				'3/4 type uncooked polenta',
				'1/2 type salt, divided',
				'1/2 type pepper, divided',
				'1/4 type freshly grated Parmesan cheese',
				'2 type fresh green beans, trimmed',
				'1 type olive oil',
				'1 type fresh lemon juice',
			],
			$this->extractor->extract(
				$this->crawler,
				'[itemprop="ingredients"]',
				['class', '_text']
			)
		);
	}
}
