<?php

namespace RecipeScraper\Extractors;

use InvalidArgumentException;

class ExtractorManager
{
    protected $instances = [
        Plural::class => null,
        PluralFromChildren::class => null,
        Singular::class => null,
    ];

    public function make($type)
    {
        if (! array_key_exists($type, $this->instances)) {
            throw new InvalidArgumentException;
        }

        if (isset($this->instances[$type])) {
            return $this->instances[$type];
        }

        return $this->instances[$type] = new $type;
    }
}
