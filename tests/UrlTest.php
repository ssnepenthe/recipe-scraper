<?php

namespace RecipeScraperTests;

use RecipeScraper\Url;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class UrlTest extends TestCase
{
    public function setUp()
    {
        $this->crawler = new Crawler(
            '<html><head></head><body></body></html>',
            'https://example.com'
        );
    }

    /** @test */
    function it_can_transform_protocol_relative_urls_to_absolute()
    {
        $urls = ['//example.com/some/path/here', 'https://example.com/some/path/here'];

        foreach ($urls as $url) {
            $this->assertEquals(
                'https://example.com/some/path/here',
                Url::relativeToAbsolute($url, $this->crawler)
            );
        }
    }

    /** @test */
    function it_does_not_modify_urls_that_it_does_not_support()
    {
        $url = '://example.com/some/path/here';

        $this->assertSame($url, Url::relativeToAbsolute($url, $this->crawler));
    }

    /** @test */
    function it_does_not_modify_urls_when_uri_has_not_been_set_on_crawler()
    {
        $url = '//example.com/some/path/here';
        $crawler = new Crawler('<html><head></head><body></body></html>');

        $this->assertSame($url, Url::relativeToAbsolute($url, $crawler));
    }
}
