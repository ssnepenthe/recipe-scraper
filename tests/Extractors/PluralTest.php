<?php

namespace RecipeScraperTests\Extractors;

use PHPUnit\Framework\TestCase;
use RecipeScraper\Extractors\Plural;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;

class PluralTest extends TestCase
{
	use UsesTestData;

	protected $crawler;
	protected $extractor;

	public function setUp()
	{
		$html = file_get_contents($this->getHtmlDataFilePath(
			'allrecipes.com/recipe-139917-joses-shrimp-ceviche'
		));

		$this->crawler = new Crawler(
			$html,
			'http://allrecipes.com/recipe/139917/joses-shrimp-ceviche/'
		);
		$this->extractor = new Plural;
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
	function it_can_extract_text_value_from_a_node_list()
	{
		$this->assertEquals(
			[
				'1 pound peeled and deveined medium shrimp',
				'1 cup fresh lime juice',
				'10 plum tomatoes, diced',
				'1 large yellow onion, diced',
				'1 jalapeno pepper, seeded and minced, or to taste',
				'2 avocados, diced (optional)',
				'2 ribs celery, diced (optional)',
				'chopped fresh cilantro to taste',
				'salt and pepper to taste',
			],
			$this->extractor->extract($this->crawler, '[itemprop="ingredients"]')
		);
	}

	/** @test */
	function it_can_extract_an_arbitrary_attribute_from_a_node_list()
	{
		$this->assertEquals(
			[
				'22005',
				'5112',
				'20453',
				'4397',
				'3725',
				'5012',
				'4292',
				'3717',
				'16421',
			],
			$this->extractor->extract(
				$this->crawler,
				'[itemprop="ingredients"]',
				'data-id'
			)
		);
	}
}
