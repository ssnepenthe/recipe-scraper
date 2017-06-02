<?php

namespace SSNepenthe\RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class SingularExtractor implements ExtractorInterface
{
	public function extract(Crawler $crawler, $selector, $attr = '_text')
	{
		$nodes = $crawler->filter($selector);

		return $nodes->count()
			? trim('_text' === $attr ? $nodes->text() : $nodes->attr($attr))
			: null;
	}
}
