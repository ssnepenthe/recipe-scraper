<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\DomCrawler\Crawler;

abstract class ScraperTestCase extends TestCase
{
    use UsesTestData;

    protected $scraper;
    protected $urls;

    public function setUp()
    {
        $urlsPath = $this->getUrlsDataFilePath($this->getHost());

        if (! file_exists($urlsPath)) {
            $this->fail(
                "Unable to locate URLs for {$this->getHost()} at {$urlsPath}"
            );
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

            $this->assertTrue($this->scraper->supports($crawler));

            $actualRecipe = $this->scraper->scrape($crawler);
            $expectedRecipe = $this->getResults($crawler);

            $this->assertEquals($expectedRecipe, $actualRecipe, 'URL: ' . $crawler->getUri());

            // $this->assertRecipeEquals($expectedRecipe, $actualRecipe);
            // $this->assertCorrectResults($crawler);
        }
    }

    // protected function assertRecipeEquals($expected, $actual, $message = '')
    // {
    //     $constraint = new ConstraintRecipeIsEqual($expected);

    //     static::assertThat($actual, $constraint, $message);
    // }

    // protected function assertCorrectResults($crawler)
    // {
    //     $actual = $this->scraper->scrape($crawler);
    //     $expected = $this->getResults($crawler);
    //     $url = $crawler->getUri();

    //     foreach ($expected as $key => $value) {
    //         if (is_array($value)) {
    //             $this->assertTrue(
    //                 is_array($actual[$key]),
    //                 "{$url} - {$key}: expected array, got " . gettype($actual[$key])
    //             );

    //             foreach ($value as $k => $v) {
    //                 $this->assertSame(
    //                     $v,
    //                     $actual[$key][$k],
    //                     "{$url} - {$key}[{$k}]"
    //                 );
    //             }
    //         } else {
    //             $this->assertSame($value, $actual[$key], "{$url} - {$key}");
    //         }
    //     }
    // }

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

    protected function getResults($crawler)
    {
        $url = $crawler->getUri();
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

    abstract protected function getHost();
    abstract protected function makeScraper();
}
