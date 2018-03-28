<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Scrapers\ScraperInterface;
use RecipeScraper\Scrapers\DelegatingScraper;
use RecipeScraper\Scrapers\ScraperResolverInterface;

class DelegatingScraperTest extends TestCase
{
    /** @test */
    public function it_delegates_to_resolver_when_performing_scrape()
    {
        $recipe = array_merge(DelegatingScraper::EMPTY_RECIPE, [
            'author' => 'doesn\'t',
            'cookingMethod' => 'really',
            'description' => 'matter',
            'image' => 'now',
            'name' => 'does',
            'publisher' => 'it',
        ]);

        $crawlerStub = $this->createMock(Crawler::class);

        $scraperStub = $this->createMock(ScraperInterface::class);
        $scraperStub->method('scrape')
            ->with($crawlerStub)
            ->willReturn($recipe);

        $resolverStub = $this->createMock(ScraperResolverInterface::class);
        $resolverStub->method('resolve')
            ->with($crawlerStub)
            ->willReturn($scraperStub);

        $scraper = new DelegatingScraper($resolverStub);

        $this->assertSame($recipe, $scraper->scrape($crawlerStub));
    }

    /** @test */
    public function it_returns_empty_recipe_for_unsupported_crawler()
    {
        $crawlerStub = $this->createMock(Crawler::class);

        $resolverStub = $this->createMock(ScraperResolverInterface::class);
        $resolverStub->method('resolve')
            ->with($crawlerStub)
            ->willReturn(false);

        $scraper = new DelegatingScraper($resolverStub);

        $this->assertSame(DelegatingScraper::EMPTY_RECIPE, $scraper->scrape($crawlerStub));
    }

    /** @test */
    public function it_delegates_to_resolver_when_checking_supports()
    {
        $supportedStub = $this->createMock(Crawler::class);
        $unsupportedStub = $this->createMock(Crawler::class);

        $resolverStub = $this->createMock(ScraperResolverInterface::class);
        $resolverStub->method('resolve')
            ->will($this->returnValueMap([
                [$unsupportedStub, false],
                [$supportedStub, $this->createMock(ScraperInterface::class)],
            ]));

        $scraper = new DelegatingScraper($resolverStub);

        $this->assertTrue($scraper->supports($supportedStub));
        $this->assertFalse($scraper->supports($unsupportedStub));
    }
}
