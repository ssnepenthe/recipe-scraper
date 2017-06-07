<?php

namespace RecipeScraperTests\Extractors;

use PHPUnit\Framework\TestCase;
use SSNepenthe\RecipeScraper\Extractors\Singular;
use SSNepenthe\RecipeScraper\Extractors\ExtractorManager;

class ExtractorManagerTest extends TestCase
{
	protected $extractor;

	public function setUp()
	{
		$this->extractor = new ExtractorManager;
	}

	public function tearDown()
	{
		$this->extractor = null;
	}

	/** @test */
	function it_throws_for_unrecognized_type()
	{
		$this->expectException(\InvalidArgumentException::class);

		$this->extractor->make('NotARealClass');
	}

	/** @test */
	function it_makes_extractor_instances_as_needed_and_caches_for_reuse()
	{
		$e = $this->extractor->make(Singular::class);

		$this->assertSame($e, $this->extractor->make(Singular::class));
	}
}
