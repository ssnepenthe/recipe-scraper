<?php

namespace RecipeScraperTests\Extractors;

use PHPUnit\Framework\TestCase;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\Singular;

class SingularTest extends TestCase
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
		$this->extractor = new Singular;
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
			'Jose\'s Shrimp Ceviche',
			$this->extractor->extract($this->crawler, '[itemprop="name"]')
		);
	}

	/** @test */
	function it_can_extract_an_arbitrary_attribute_from_a_node_list()
	{
		$this->assertEquals(
			'PT10M',
			$this->extractor->extract(
				$this->crawler,
				'[itemprop="cookTime"]',
				'datetime'
			)
		);
	}
}
