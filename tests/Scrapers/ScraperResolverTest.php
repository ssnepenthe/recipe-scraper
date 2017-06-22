<?php

namespace RecipeScraperTests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Scrapers\ScraperResolver;
use RecipeScraper\Scrapers\ScraperInterface;

class ScraperResolverTest extends TestCase
{
	/** @test */
	public function it_correctly_resolves_scraper_based_on_scraper_supports()
	{
		$crawlerStub = $this->createMock(Crawler::class);

        $firstScraperStub = $this->createMock(ScraperInterface::class);
        $firstScraperStub->method('supports')
            ->with($crawlerStub)
            ->willReturn(false);
        $secondScraperStub = $this->createMock(ScraperInterface::class);
        $secondScraperStub->method('supports')
            ->with($crawlerStub)
            ->willReturn(false);
        $thirdScraperStub = $this->createMock(ScraperInterface::class);
        $thirdScraperStub->method('supports')
            ->with($crawlerStub)
            ->willReturn(true);

        $firstResolver = new ScraperResolver([$firstScraperStub, $secondScraperStub]);

        $secondResolver = new ScraperResolver;
        $secondResolver->add($firstScraperStub);
        $secondResolver->add($secondScraperStub);
        $secondResolver->add($thirdScraperStub);

        $this->assertFalse($firstResolver->resolve($crawlerStub));
        $this->assertSame($thirdScraperStub, $secondResolver->resolve($crawlerStub));
	}
}
