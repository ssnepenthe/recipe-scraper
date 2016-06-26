<?php
/**
 * Locator class for identifying which parser class should be used.
 */

namespace SSNepenthe\RecipeParser;

use SSNepenthe\RecipeParser\Exception\NoMatchingParserException;

class ParserLocator
{
    const SCHEMA_ORG = 'SSNepenthe\\RecipeParser\\Parsers\\SchemaOrg';

    protected $dom;
    protected $host;
    protected $html;
    protected $parsers;
    protected $xpath;

    public function __construct($url, $html, $extra_parsers = [])
    {
        if (! is_string($url)) {
            throw new \InvalidArgumentException(sprintf(
                'The url parameter is required to be string, was: %s',
                gettype($url)
            ));
        }

        if (! is_string($html)) {
            throw new \InvalidArgumentException(sprintf(
                'The html parameter is required to be string, was: %s',
                gettype($html)
            ));
        }

        $this->host = strtolower(parse_url($url, PHP_URL_HOST));

        if (0 === strpos($this->host, 'www.')) {
            $this->host = substr($this->host, 4);
        }

        $this->html = $html;

        $this->parsers = require sprintf(
            '%s/config/parsers.php',
            dirname(__DIR__)
        );

        // Allow user to supply custom parser classes.
        if (! empty($extra_parsers)) {
            $this->parsers = array_merge($this->parsers, $extra_parsers);
        }
    }

    public function dom()
    {
        if (! $this->dom instanceof \DOMDocument) {
            $original_error_state = libxml_use_internal_errors(true);

            $this->dom = new \DOMDocument;
            $this->dom->loadHTML($this->html);

            libxml_clear_errors();
            libxml_use_internal_errors($original_error_state);
        }

        return $this->dom;
    }

    public function locate()
    {
        if ($class = $this->getRegisteredParser()) {
            return $class;
        }

        if ($class = $this->getMarkupParser()) {
            return $class;
        }

        throw new NoMatchingParserException(sprintf(
            'Unable to find parser for %s',
            $this->host
        ));
    }

    public function xpath()
    {
        if (! $this->xpath instanceof \DOMXpath) {
            $this->xpath = new \DOMXpath($this->dom());
        }

        return $this->xpath;
    }

    protected function hasSchemaOrg()
    {
        $nodes = $this->xpath()->query(
            // @todo Use symfony/css-selector?
            '//*[contains(@itemtype, "schema.org/Recipe")]'
        );

        if ($nodes->length) {
            return true;
        }

        return false;
    }

    /**
     * Placeholder function so we can easilty add other markup types as needed.
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
