<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class DelegatingScraper implements ScraperInterface
{
    protected $resolver;

    public function __construct(ScraperResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    public function scrape(Crawler $crawler) : array
    {
        if (false === $scraper = $this->resolver->resolve($crawler)) {
            return $this->generateEmptyRecipe();
        }

        return $scraper->scrape($crawler);
    }

    public function supports(Crawler $crawler) : bool
    {
        return false !== $this->resolver->resolve($crawler);
    }

    protected function generateEmptyRecipe() : array
    {
        return [
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
    }
}
