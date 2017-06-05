<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use RecipeScraperTests\UsesTestData;

class ScraperTestCase extends TestCase
{
	use UsesTestData;

	protected $host = null;
	protected $urls = [];

	public function setUp()
	{
		if (is_null($this->host)) {
			$this->fail(
				'Individual test classes must define the protected $host property'
			);
		}

		$urlsPath = $this->getUrlsDataFilePath($this->host);

		if (! file_exists($urlsPath)) {
			$this->fail("Unable to locate URLs for {$this->host} at {$urlsPath}");
		}

		$this->urls = static::includeFile($urlsPath);
	}

	/** @test */
	function it_correctly_scrapes_all_provided_urls()
	{
		$extractor = new \SSNepenthe\RecipeScraper\Extractors\ExtractorManager;

		$resolver = new \SSNepenthe\RecipeScraper\Scrapers\ScraperResolver([
			new \SSNepenthe\RecipeScraper\Scrapers\AllRecipesCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\SpryLivingCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\ThePioneerWomanCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwBettyCrockerCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwBhgCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwDelishCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwEpicuriousCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwFoodAndWineCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwJustATasteCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwPaulaDeenCom($extractor),

			// LD+JSON
			new \SSNepenthe\RecipeScraper\Scrapers\ScrippsNetworks($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\WwwMyRecipesCom($extractor),
			new \SSNepenthe\RecipeScraper\Scrapers\SchemaOrgJsonLd($extractor),
		]);

		foreach ($this->urls as $url) {
			$crawler = $this->makeCrawler($url);
			$expectedResults = $this->getResults($url);
			$scraper = $resolver->resolve($crawler);
			$actualResults = $scraper->scrape($crawler);

			$this->assertSameResults($expectedResults, $actualResults, $url);
		}
	}

	protected function assertSameResults($expected, $actual, $url)
	{
		foreach (array_keys($expected) as $key) {
			$this->assertEquals($expected[$key], $actual[$key], "{$url} - {$key}");
		}
	}

	protected function getHtml($url)
	{
		$htmlPath = $this->getHtmlDataFilePathFromUrl($url);

		if (! file_exists($htmlPath)) {
			$this->fail(
				"Unable to locate test HTML for {$url} at {$htmlPath}\n"
					. 'Please run ./bin/test-tools get-html --missing'
			);
		}

		return file_get_contents($htmlPath);
	}

	protected function getResults($url)
	{
		$resultsPath = $this->getResultsDataFilePathFromUrl($url);

		if (! file_exists($resultsPath)) {
			$this->fail(
				"Unable to locate test results for {$url} at {$resultsPath}\n"
					. 'Please run ./bin/test-tools stub-results'
			);
		}

		$results = static::includeFile($resultsPath);

		return $results;
	}

	protected function makeCrawler($url)
	{
		return new \Symfony\Component\DomCrawler\Crawler($this->getHtml($url), $url);
	}
}
