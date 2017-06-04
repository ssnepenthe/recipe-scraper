<?php

namespace SSNepenthe\RecipeScraper;

/**
 * Read array via dot notation.
 *
 * Adapted from illuminate/support.
 */
class Arr
{
    public static function exists(array $array, $key)
    {
        return array_key_exists($key, $array);
    }

    public static function get(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    public static function normalize(array $value)
    {
        if (! static::ofStrings($value)) {
            return [];
        }

        $value = array_map([Str::class, 'normalize'], $value);

        return array_values(array_filter($value));
    }

    public static function ofStrings(array $value)
    {
        $notStrings = array_filter($value, function($val) {
            return ! is_string($val);
        });

        return ! count($notStrings);
    }
}
