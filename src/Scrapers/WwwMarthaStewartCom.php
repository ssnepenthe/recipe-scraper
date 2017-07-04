<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Occasionally includes links to other recipes in ingredients section
 * Has keywords available which could potentially be used as extra categories.
 * Also has a "variations" section.
 */
class WwwMarthaStewartCom extends SchemaOrgJsonLd
{
	use ExtractsDataFromCrawler;

	protected function extractNotes(Crawler $crawler, array $json)
	{
		return $this->extractArray($crawler, '.notes-cooks .note-text');
	}
}
