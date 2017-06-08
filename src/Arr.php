<?php

namespace RecipeScraper;

class Arr
{
    /**
     * Adapted from illuminate/support.
     */
    public static function get($array, $key, $default = null)
    {
        if (! is_array($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    public static function normalize($value) : array
    {
        if (! static::ofStrings($value)) {
            return [];
        }

        return array_values(array_filter(array_map(
            [Str::class, 'normalize'],
            $value
        )));
    }

    public static function ofStrings($value) : bool
    {
        return is_array($value) && ! count(array_filter($value, function ($val) {
            return ! is_string($val);
        }));
    }
}
