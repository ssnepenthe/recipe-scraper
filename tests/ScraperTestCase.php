<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Scrapers\ScraperFactory;

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
		$scraper = ScraperFactory::make();

		foreach ($this->urls as $url) {
			$this->assertSameResults(
				$this->getResults($url),
				$scraper->scrape(
					$this->makeCrawler($url)
				),
				$url
			);
		}
	}

	protected function assertSameResults($expected, $actual, $url)
	{
		foreach (array_keys($expected) as $key) {
			$this->assertSame($expected[$key], $actual[$key], "{$url} - {$key}");
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
		return new Crawler($this->getHtml($url), $url);
	}
}
