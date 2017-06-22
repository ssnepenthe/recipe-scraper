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
        $recipe = [
            'author' => 'doesn\'t',
            'categories' => null,
            'cookingMethod' => 'really',
            'cookTime' => null,
            'cuisines' => null,
            'description' => 'matter',
            'image' => 'now',
            'ingredients' => null,
            'instructions' => null,
            'name' => 'does',
            'prepTime' => null,
            'publisher' => 'it',
            'totalTime' => null,
            'url' => null,
            'yield' => null,
        ];

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
        $recipe = [
            'author' => null,
            'categories' => null,
            'cookingMethod' => null,
            'cookTime' => null,
            'cuisines' => null,
            'description' => null,
            'image' => null,
            'ingredients' => null,
            'instructions' => null,
            'name' => null,
            'prepTime' => null,
            'publisher' => null,
            'totalTime' => null,
            'url' => null,
            'yield' => null,
        ];

        $crawlerStub = $this->createMock(Crawler::class);

        $resolverStub = $this->createMock(ScraperResolverInterface::class);
        $resolverStub->method('resolve')
            ->with($crawlerStub)
            ->willReturn(false);

        $scraper = new DelegatingScraper($resolverStub);

        $this->assertSame($recipe, $scraper->scrape($crawlerStub));
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
