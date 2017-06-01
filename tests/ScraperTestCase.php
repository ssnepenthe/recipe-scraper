<?php

namespace RecipeScraperTests;

use DateInterval;
use PHPUnit_Framework_TestCase;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\ScraperLocator;

class ScraperTestCase extends PHPUnit_Framework_TestCase
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
		foreach ($this->urls as $url) {
			$html = $this->getHtml($url);
			$expectedResults = $this->getResults($url);

			$crawler = new Crawler($html, $url);
			$locator = new ScraperLocator($crawler);
			$scraperClass = $locator->locate();

			$scraper = new $scraperClass($crawler);

			$actualResults = $scraper->scrape();

			$this->assertSameResults($expectedResults, $actualResults, $url);
		}
	}

	protected function assertSameResults($expected, $actual, $url)
	{
		$newToOldMap = [
			'categories' => 'recipeCategories',
			'cuisines' => 'recipeCuisines',
			'ingredients' => 'recipeIngredients',
			'instructions' => 'recipeInstructions',
			'yield' => 'recipeYield',
		];

		// @todo Temporary - just until scraper refactor.
		foreach ($expected as $key => $value) {
			$actualValue = isset($newToOldMap[$key])
				? $actual->{$newToOldMap[$key]}
				: $actual->{$key};

			if ('ingredients' === $key || 'instructions' === $key) {
				$newValue = [];

				foreach ($actualValue as $group) {
					foreach ($group as $gKey => $gValue) {
						if (is_string($gValue)) {
							// title
							$newValue[] = $gValue;
						} else {
							// data
							$newValue = array_merge($newValue, $gValue);
						}
					}
				}

				$actualValue = array_values(array_filter($newValue));
			}

			$this->assertEquals($value, $actualValue, "{$url} - {$key}");
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

		foreach (['cookTime', 'prepTime', 'totalTime'] as $timestamp) {
			if ($results[$timestamp]) {
				$results[$timestamp] = new DateInterval($results[$timestamp]);
			}
		}

		return $results;
	}
}
