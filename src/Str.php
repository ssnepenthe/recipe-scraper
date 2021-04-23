<?php

namespace RecipeScraper;

class Str
{
    /**
     * Adapted from danielstjules/stringy.
     */
    public static function collapseWhitespace(string $string) : string
    {
        return static::trim(preg_replace("/[[:space:]]+/ums", ' ', $string));
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function htmlDecode(string $string, int $flags = ENT_QUOTES) : string
    {
        return html_entity_decode($string, $flags, mb_internal_encoding());
    }

    public static function isList(string $string) : bool
    {
        // @todo Incredibly naive... Need to revisit at some point.
        return false !== strpos($string, ',');
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function lines(string $string)
    {
        return static::split($string, '[\r\n]{1,2}');
    }

    public static function normalize(string $string) : string
    {
        $string = static::htmlDecode($string);
        $string = static::tidy($string);
        $string = static::stripTags($string);
        $string = static::collapseWhitespace($string); // Also calls trim.

        return $string;
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function split(string $string, string $pattern, int $limit = -1)
    {
        if ($limit === 0) {
            return [];
        }

        if ($pattern === '') {
            return [$string];
        }

        if ($limit > 0) {
            $limit += 1;
        }

        $array = preg_split("/{$pattern}/", $string, $limit);

        if ($limit > 0 && count($array) === $limit) {
            array_pop($array);
        }

        return $array;
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function startsWith(
        string $string,
        string $substring,
        bool $caseSensitive = true
    ) : bool {
        $encoding = mb_internal_encoding();

        $substringLength = mb_strlen($substring, $encoding);
        $startOfStr = mb_substr($string, 0, $substringLength, $encoding);

        if (! $caseSensitive) {
            $substring = mb_strtolower($substring, $encoding);
            $startOfStr = mb_strtolower($startOfStr, $encoding);
        }

        return (string) $substring === $startOfStr;
    }

    public static function stripTags(string $string) : string
    {
        return strip_tags($string);
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function tidy(string $string) : string
    {
        return preg_replace([
            '/\x{2026}/u',
            '/[\x{201C}\x{201D}]/u',
            '/[\x{2018}\x{2019}]/u',
            '/[\x{2013}\x{2014}]/u',
        ], [
            '...',
            '"',
            "'",
            '-',
        ], $string);
    }

    /**
     * Adapted from danielstjules/stringy.
     */
    public static function trim(string $string, string $chars = null) : string
    {
        // @todo Just use trim()?
        $chars = ($chars) ? preg_quote($chars) : '[:space:]';

        return preg_replace("/^[{$chars}]+|[{$chars}]+\$/ums", '', $string);
    }
}
