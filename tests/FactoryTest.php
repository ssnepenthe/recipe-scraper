<?php

namespace RecipeScraperTests;

use RecipeScraper\Factory;
use PHPUnit\Framework\TestCase;
use RecipeScraper\Scrapers\AllRecipesCom;
use RecipeScraper\Scrapers\DelegatingScraper;

class FactoryTest extends TestCase
{
	use UsesTestData;

	/** @test */
	public function it_can_make_individual_scrapers()
	{
		$scraper = Factory::make(AllRecipesCom::class);

		$this->assertInstanceOf(AllRecipesCom::class, $scraper);
	}

	/** @test */
	public function it_can_make_a_delegating_scraper()
	{
		$scraper = Factory::make();

		$this->assertInstanceOf(DelegatingScraper::class, $scraper);
	}

	/** @test */
	public function it_caches_scraper_instances()
	{
		$scraper = Factory::make(AllRecipesCom::class);

		$this->assertSame(Factory::make(AllRecipesCom::class), $scraper);
	}

	/** @test */
	public function it_caches_a_delegating_scraper_instance()
	{
		$scraper = Factory::make();

		$this->assertSame(Factory::make(), $scraper);
	}

	/** @test */
	public function it_makes_a_delegating_scraper_which_supports_all_tested_urls()
	{
		$scraper = Factory::make();
		$urls = $this->getTestUrls();

		foreach ($urls as $url) {
			$crawler = $this->makeCrawler($url);

			$this->assertTrue($scraper->supports($crawler));
		}
	}

	/** @test */
	public function it_makes_a_delegating_scraper_which_can_correctly_scrape_all_tested_urls()
	{
		// Double tested... But it ensures that I don't forget to add a class to the factory.
		$scraper = Factory::make();
		$urls = $this->getTestUrls();

		foreach ($urls as $url) {
			$crawler = $this->makeCrawler($url);

			$this->assertEquals(
                $this->getResults($crawler),
                $scraper->scrape($crawler),
                'URL: ' . $crawler->getUri()
            );
		}
	}
}
