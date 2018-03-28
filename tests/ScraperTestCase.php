<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use RecipeScraper\Scrapers\DelegatingScraper;

abstract class ScraperTestCase extends TestCase
{
    use UsesTestData;

    protected $scraper;
    protected $urls;

    public function setUp()
    {
        $urlsPath = $this->getUrlsDataFilePath($this->getHost());

        if (! file_exists($urlsPath)) {
            $this->fail("Unable to locate URLs for {$this->getHost()} at {$urlsPath}");
        }

        $this->scraper = $this->makeScraper();
        $this->urls = static::includeFile($urlsPath);
    }

    public function tearDown()
    {
        $this->scraper = null;
        $this->urls = null;
    }

    /** @test */
    public function it_correctly_scrapes_all_provided_urls()
    {
        foreach ($this->urls as $url) {
            $crawler = $this->makeCrawler($url);

            static::assertRecipeEquals(
                $this->getResults($crawler),
                $this->scraper->scrape($crawler),
                'URL: ' . $crawler->getUri()
            );
        }
    }

    /** @test */
    public function it_supports_all_provided_urls()
    {
        foreach ($this->urls as $url) {
            $crawler = $this->makeCrawler($url);

            $this->assertTrue($this->scraper->supports($crawler), 'URL: ' . $crawler->getUri());
        }
    }

    abstract protected function getHost();
    abstract protected function makeScraper();

    public static function assertRecipeEquals(array $expected, array $actual, $message = '')
    {
        // This whole comparison is kind of gross, but it is the first small step toward a
        // (hopefully) much more robust overall test system for this recipe scraper.
        foreach (DelegatingScraper::EMPTY_RECIPE as $key => $_) {
            if (! array_key_exists($key, $expected)) {
                static::fail(
                    static::multiMessage(
                        $message,
                        "Required key [{$key}] does not exist on expected recipe array"
                    )
                );
            }

            if (! array_key_exists($key, $actual)) {
                static::fail(
                    static::multiMessage(
                        $message,
                        "Required key [{$key}] does not exist on actual recipe array"
                    )
                );
            }

            static::assertEquals(
                $expected[$key],
                $actual[$key],
                static::multiMessage($message, "Error comparing {$key} recipe key:")
            );
        }

        $extraActual = array_diff_key($actual, DelegatingScraper::EMPTY_RECIPE);

        foreach ($extraActual as $key => $_) {
            if (! array_key_exists($key, $expected)) {
                static::fail(
                    static::multiMessage(
                        $message,
                        "Actual recipe array contains an extra key [{$key}] that does not exists on expected recipe array"
                    )
                );
            }

            static::assertEquals(
                $expected[$key],
                $actual[$key],
                static::multiMessage($message, "Error comparing extra recipe key, {$key}:")
            );
        }
    }

    protected static function multiMessage(string ...$messages)
    {
        return implode(PHP_EOL, $messages);
    }
}
