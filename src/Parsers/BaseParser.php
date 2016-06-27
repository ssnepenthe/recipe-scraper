<?php

namespace SSNepenthe\RecipeParser\Parsers;

use SSNepenthe\RecipeParser\Interfaces\Parser;
use SSNepenthe\RecipeParser\Schema\Recipe;
use SSNepenthe\RecipeParser\Util\Normalize;
use SSNepenthe\RecipeParser\Util\Format;
use Symfony\Component\CssSelector\CssSelectorConverter;

abstract class BaseParser implements Parser
{
    protected $config;
    protected $html;
    protected $recipe;

    public function __construct($html = null)
    {
        if (! is_null($html)) {
            $this->setHtml($html);
        }
    }

    protected function isValidProperty($key)
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * Creates four types of virtual methods:
     * fetch*(), format*(), normalize*() and set*()
     */
    public function __call($name, $arguments)
    {
        if (empty($arguments)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        $prefix = substr($name, 0, 3);
        $suffix = substr($name, 3);
        $property = lcfirst($suffix);

        if ('set' === $prefix && $this->isValidProperty($property)) {
            $value = call_user_func(
                [$this, sprintf('fetch%s', $suffix)],
                $arguments[0]
            );

            $value = call_user_func(
                [$this, sprintf('normalize%s', $suffix)],
                $value
            );

            $value = call_user_func(
                [$this, sprintf('format%s', $suffix)],
                $value
            );

            return $value;
        }

        $prefix = substr($name, 0, 5);
        $suffix = substr($name, 5);
        $property = lcfirst($suffix);

        // Fetch/get?
        if ('fetch' === $prefix && $this->isValidProperty($property)) {
            return $this->itemFromNodeList($arguments[0], $property);
        }

        $prefix = substr($name, 0, 6);
        $suffix = substr($name, 6);
        $property = lcfirst($suffix);

        // Format/prepare?
        if ('format' === $prefix && $this->isValidProperty($property)) {
            if (is_array($arguments[0])) {
                return array_map([Format::class, 'line'], $arguments[0]);
            } else {
                return Format::line($arguments[0]);
            }
        }

        $prefix = substr($name, 0, 9);
        $suffix = substr($name, 9);
        $property = lcfirst($suffix);

        // Normalize/clean?
        if ('normalize' === $prefix && $this->isValidProperty($property)) {
            if (is_array($arguments[0])) {
                return array_map(
                    [Normalize::class, 'whiteSpace'],
                    $arguments[0]
                );
            } else {
                return Normalize::whiteSpace($arguments[0]);
            }
        }

        return call_user_func_array([$this, $name], $arguments);
    }

    public function parse()
    {
        if (! isset($this->html)) {
            // @todo
            throw new \RuntimeException();
        }

        $this->recipe = new Recipe;

        $this->configure();
        $this->applyConfigDefaults();
        $this->validateConfig();

        $original_error_state = libxml_use_internal_errors(true);

        $dom = new \DOMDocument;
        $dom->loadHTML($this->html);

        libxml_clear_errors();
        libxml_use_internal_errors($original_error_state);

        $xpath = new \DOMXPath($dom);

        $converter = new CssSelectorConverter;

        foreach ($this->config as $key => $value) {
            $nodes = $xpath->query($converter->toXPath($value['selector']));
            $method = sprintf('set%s', ucfirst($key));

            // Callback should process $nodes and return value for recipe.

            $value = call_user_func([$this, $value['callback']], $nodes);

            if ($value) {
                call_user_func([$this->recipe, $method], $value);
            }
        }

        unset($dom, $xpath, $converter, $key, $value, $nodes);

        return $this->recipe;
    }

    public function setHtml($html)
    {
        if (! is_string($html)) {
            // @todo
            throw new \InvalidArgumentException();
        }

        $this->html = $html;
    }

    protected function applyConfigDefaults()
    {
        $location_defaults = [
            '@content',
            '@datetime',
            '@href',
            '@src',
            'nodeValue',
        ];

        foreach ($this->config as $key => $value) {
            if (! isset($value['callback'])) {
                $this->config[ $key ]['callback'] = sprintf(
                    'set%s',
                    ucfirst($key)
                );
            }

            if (! isset($value['locations'])) {
                $this->config[ $key ]['locations'] = $location_defaults;
            }
        }
    }

    protected function validateConfig()
    {
        if (! empty($invalid = array_diff(
            array_keys($this->config),
            $this->recipe->getKeys()
        ))) {
            // @todo
            throw new \RuntimeException();
        }

        foreach ($this->config as $key => $value) {
            if (! is_callable([ $this, $value['callback'] ])) {
                // @todo
                throw new \RuntimeException();
            }

            $locations = array_filter($value['locations'], function ($value) {
                return is_string($value);
            });

            if (empty($locations)) {
                // @todo
                throw new \RuntimeException();
            }

            if (! isset($value['selector'])) {
                // @todo
                throw new \RuntimeException();
            }

            if (! is_string($value['selector'])) {
                // @todo
                throw new \RuntimeException();
            }
        }
    }

    /**
     * Retrieve value in $locations of the first item from $nodelist.
     */
    protected function itemFromNodeList(\DOMNodeList $nodelist, $property)
    {
        // Bail if no nodes.
        if (! $nodelist->length) {
            // @todo What to return on failure?
            return null;
        }

        $locations = $this->config[ $property ]['locations'];

        $node = $nodelist->item(0);
        // @todo What to return on failure?
        $value = null;

        foreach ($locations as $location) {
            if ('@' === substr($location, 0, 1)) {
                // Item attribute reference.
                $location = substr($location, 1);

                if ($node->hasAttribute($location)) {
                    $value = trim($node->getAttribute($location));
                    break;
                }
            } else {
                // Object property reference.
                if ($node->{$location}) {
                    $value = trim($node->{$location});
                    break;
                }
            }
        }

        return $value;
    }

    /**
     * Retrieve values in $locations from all items in $nodelist.
     */
    protected function listFromNodeList(\DOMNodeList $nodelist, $property)
    {
        // Bail if no nodes.
        if (! $nodelist->length) {
            // @todo What to return on failure?
            return [];
        }

        $locations = $this->config[ $property ]['locations'];
        $value = [];

        foreach ($nodelist as $node) {
            foreach ($locations as $location) {
                if ('@' === substr($location, 0, 1)) {
                    // Item attribute reference.
                    $location = substr($location, 1);

                    if ($node->hasAttribute($location)) {
                        $value[] = trim($node->getAttribute($location));
                    }
                } else {
                    // Object property reference.
                    if ($node->{$location}) {
                        $value[] = trim($node->{$location});
                    }
                }
            }
        }

        /**
         * Remove empty entries.
         * Normalize::spaces() helps filter out entries with chars like &nbsp;.
         * Array_values is used to re-index the array and keep phpunit quiet.
         * In particular, this is necessary for PaulaDeen.com.
         */
        $value = array_values( array_filter( $value, function( $value ) {
            $value = trim( Normalize::spaces( $value ) );

            return ! empty( $value );
        } ) );

        return $value;
    }

    protected function looksLikeGroupTitle($value)
    {
        if ( ':' === substr( $value, -1 ) ) {
            return true;
        }

        if ( strtoupper( $value ) === $value ) {
            return true;
        }

        return false;
    }

    protected function createListGroups(array $values)
    {
        $titles = [];

        foreach ($values as $key => $value) {
            if (! $this->looksLikeGroupTitle($value)) {
                continue;
            }

            $titles[] = $key;
        }

        if (empty($titles)) {
            return [ [
                'title' => '',
                'data' => $values,
            ] ];
        }

        $groups = [];
        $count = count($titles);
        $counter = 0;

        // There are titles, but the first group is title-less.
        if ( 0 !== $titles[0] ) {
            $groups[] = [
                'title' => '',
                'data' => array_slice( $values, 0, $titles[0] )
            ];
        }

        foreach ($titles as $key => $position) {
            $counter++;

            $groups[] = [
                'title' => Normalize::groupTitle($values[ $position ]),
                'data' => array_slice(
                    $values,
                    $position + 1,
                    $counter === $count ? null : $titles[ $key + 1 ] - ( $position + 1 )
                )
            ];
        }

        return $groups;
    }

    abstract protected function configure();

    /**
     * Lots of repetition here.
     */
    protected function fetchRecipeCategories(\DOMNodeList $nodes)
    {
        return $this->listFromNodeList($nodes, 'recipeCategories');
    }

    protected function fetchRecipeCuisines(\DOMNodeList $nodes)
    {
        return $this->listFromNodeList($nodes, 'recipeCuisines');
    }

    protected function fetchRecipeIngredients(\DOMNodeList $nodes)
    {
        return $this->listFromNodeList($nodes, 'recipeIngredients');
    }

    protected function fetchRecipeInstructions(\DOMNodeList $nodes)
    {
        return $this->listFromNodeList($nodes, 'recipeInstructions');
    }

    protected function formatCookTime($value) {
        if (! $value) {
            return $value;
        }

        return new \DateInterval($value);
    }

    protected function formatPrepTime($value) {
        if (! $value) {
            return $value;
        }

        return new \DateInterval($value);
    }

    protected function formatRecipeIngredients(array $ingredients)
    {
        return $this->createListGroups($ingredients);
    }

    protected function formatRecipeInstructions(array $instructions)
    {
        return $this->createListGroups($instructions);
    }

    protected function formatTotalTime($value) {
        if (! $value) {
            return $value;
        }

        return new \DateInterval($value);
    }

    protected function normalizeAuthor($author)
    {
        $author = Normalize::whiteSpace($author);
        $author = Normalize::author($author);

        return $author;
    }

    protected function normalizeRecipeIngredients(array $ingredients)
    {
        $ingredients = array_map(
            [Normalize::class, 'whiteSpace'],
            $ingredients
        );

        $ingredients = array_map(
            [Normalize::class, 'fractions'],
            $ingredients
        );

        return $ingredients;
    }

    protected function normalizeRecipeInstructions(array $instructions)
    {
        $instructions = array_map([Normalize::class, 'whiteSpace'], $instructions);
        $instructions = array_map([Normalize::class, 'orderedList'], $instructions);

        return $instructions;
    }

    protected function normalizeRecipeYield($yield)
    {
        return Normalize::recipeYield($yield);
    }
}
