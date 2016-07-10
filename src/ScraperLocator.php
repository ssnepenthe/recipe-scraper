<?php
/**
 * Locator class for identifying which parser class should be used.
 */

namespace SSNepenthe\RecipeScraper;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Exception\NoMatchingScraperException;

class ScraperLocator
{
    const SCHEMA_ORG = 'SSNepenthe\\RecipeScraper\\Scrapers\\SchemaOrg';

    protected $crawler;
    protected $host;
    protected $parsers;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;

        $this->host = strtolower(parse_url(
            $this->crawler->getUri(),
            PHP_URL_HOST
        ));

        if (0 === strpos($this->host, 'www.')) {
            $this->host = substr($this->host, 4);
        }

        $this->parsers = require sprintf(
            '%s/config/scrapers.php',
            dirname(__DIR__)
        );

        $this->parsers = array_map(function ($value) {
            return sprintf('SSNepenthe\\RecipeScraper\\Scrapers\\%s', $value);
        }, $this->parsers);
    }

    public function locate()
    {
        if ($class = $this->getRegisteredParser()) {
            return $class;
        }

        if ($class = $this->getMarkupParser()) {
            return $class;
        }

        throw new NoMatchingScraperException(sprintf(
            'Unable to find parser for %s',
            $this->host
        ));
    }

    protected function hasSchemaOrg()
    {
        $filteredCrawler = $this->crawler->filter(
            '[itemtype*="schema.org/Recipe"]'
        );

        if ($filteredCrawler->count()) {
            return true;
        }

        return false;
    }

    /**
     * Placeholder function so we can easily add other markup types as needed.
     */
    protected function getMarkupParser()
    {
        if ($this->hasSchemaOrg()) {
            return self::SCHEMA_ORG;
        }

        return false;
    }

    protected function getRegisteredParser()
    {
        if (isset($this->parsers[ $this->host ])) {
            return $this->parsers[ $this->host ];
        }

        return false;
    }
}
