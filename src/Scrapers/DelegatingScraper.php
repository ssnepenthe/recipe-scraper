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
        if (false === $scraper = $this->resolver->resolve($url)) {
            return $this->generateEmptyRecipe();
        }

        return $scraper->scrape($url);
    }

    public function supports(Crawler $crawler) : bool
    {
        return false !== $this->resolver->resolve($url);
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
