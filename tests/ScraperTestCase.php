<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;

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

            $this->assertEquals(
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
}
