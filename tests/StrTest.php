<?php

namespace RecipeScraperTests;

use RecipeScraper\Str;
use PHPUnit\Framework\TestCase;

/**
 * Adapted from danielstjules/stringy.
 */
class StrTest extends TestCase
{
    /** @test */
    function it_can_collapse_whitespace()
    {
        foreach ([
            ['foo bar', '  foo   bar  '],
            ['test string', 'test string'],
            ['Ο συγγραφέας', '   Ο     συγγραφέας  '],
            ['123', ' 123 '],
            ['', ' ', 'UTF-8'], // no-break space (U+00A0)
            ['', '           ', 'UTF-8'], // spaces U+2000 to U+200A
            ['', ' ', 'UTF-8'], // narrow no-break space (U+202F)
            ['', ' ', 'UTF-8'], // medium mathematical space (U+205F)
            ['', '　', 'UTF-8'], // ideographic space (U+3000)
            ['1 2 3', '  1  2  3　　', 'UTF-8'],
            ['', ' '],
            ['', ''],
        ] as [$expected, $input]) {
            $this->assertSame($expected, Str::collapseWhitespace($input));
        }
    }

    /** @test */
    function it_can_decode_html_entities()
    {
        foreach ([
            ['&', '&amp;'],
            ['"', '&quot;'],
            // ["'", '&#039;', ENT_QUOTES], // @todo ???
            ['<', '&lt;'],
            ['>', '&gt;'],
        ] as [$expected, $input]) {
            $this->assertSame($expected, Str::htmlDecode($input));
        }
    }

    /** @test */
    function it_can_break_a_string_into_lines()
    {
        foreach ([
            // @todo Stringy bug where we get an extra empty entry? Needs some research.
            [[''], ""],
            [['', ''], "\r\n"],
            [['foo', 'bar'], "foo\nbar"],
            [['foo', 'bar'], "foo\rbar"],
            [['foo', 'bar'], "foo\r\nbar"],
            [['foo', '', 'bar'], "foo\r\n\r\nbar"],
            [['foo', 'bar', ''], "foo\r\nbar\r\n"],
            [['', 'foo', 'bar'], "\r\nfoo\r\nbar"],
            // [['fòô', 'bàř'], "fòô\nbàř", 'UTF-8'],
            // [['fòô', 'bàř'], "fòô\rbàř", 'UTF-8'],
            // [['fòô', 'bàř'], "fòô\n\rbàř", 'UTF-8'],
            // [['fòô', 'bàř'], "fòô\r\nbàř", 'UTF-8'],
            // [['fòô', '', 'bàř'], "fòô\r\n\r\nbàř", 'UTF-8'],
            // [['fòô', 'bàř', ''], "fòô\r\nbàř\r\n", 'UTF-8'],
            // [['', 'fòô', 'bàř'], "\r\nfòô\r\nbàř", 'UTF-8'],
        ] as [$expected, $input]) {
            $this->assertSame($expected, Str::lines($input));
        }
    }

    /** @test */
    function it_can_normalize_strings()
    {
        $html = '&amp;';
        $tidy = '…';
        $trim = ' test ';
        $whitespace = 'one two  three   done';

        $this->assertEquals('&', Str::normalize($html));
        $this->assertEquals('...', Str::normalize($tidy));
        $this->assertEquals('test', Str::normalize($trim));
        $this->assertEquals('one two three done', Str::normalize($whitespace));
    }

    /** @test */
    function it_can_split_a_string()
    {
        foreach ([
            [['foo,bar,baz'], 'foo,bar,baz', '', -1],
            [['foo,bar,baz'], 'foo,bar,baz', '-', -1],
            [['foo', 'bar', 'baz'], 'foo,bar,baz', ',', -1],
            [['foo', 'bar', 'baz'], 'foo,bar,baz', ',', -1],
            [['foo', 'bar', 'baz'], 'foo,bar,baz', ',', -1],
            [[], 'foo,bar,baz', ',', 0],
            [['foo'], 'foo,bar,baz', ',', 1],
            [['foo', 'bar'], 'foo,bar,baz', ',', 2],
            [['foo', 'bar', 'baz'], 'foo,bar,baz', ',', 3],
            [['foo', 'bar', 'baz'], 'foo,bar,baz', ',', 10],
            // [['fòô,bàř,baz'], 'fòô,bàř,baz', '-', -1, 'UTF-8'],
            // [['fòô', 'bàř', 'baz'], 'fòô,bàř,baz', ',', -1, 'UTF-8'],
            // [['fòô', 'bàř', 'baz'], 'fòô,bàř,baz', ',', -1, 'UTF-8'],
            // [['fòô', 'bàř', 'baz'], 'fòô,bàř,baz', ',', -1, 'UTF-8'],
            // [[], 'fòô,bàř,baz', ',', 0, 'UTF-8'],
            // [['fòô'], 'fòô,bàř,baz', ',', 1, 'UTF-8'],
            // [['fòô', 'bàř'], 'fòô,bàř,baz', ',', 2, 'UTF-8'],
            // [['fòô', 'bàř', 'baz'], 'fòô,bàř,baz', ',', 3, 'UTF-8'],
            // [['fòô', 'bàř', 'baz'], 'fòô,bàř,baz', ',', 10, 'UTF-8']
        ] as [$expected, $string, $pattern, $limit]) {
            $this->assertSame($expected, Str::split($string, $pattern, $limit));
        }
    }

    /** @test */
    function it_can_check_if_a_string_starts_with_a_substring()
    {
        foreach ([
            [true, 'foo bars', 'foo bar', true],
            [true, 'FOO bars', 'foo bar', false],
            [true, 'FOO bars', 'foo BAR', false],
            // [true, 'FÒÔ bàřs', 'fòô bàř', false, 'UTF-8'],
            // [true, 'fòô bàřs', 'fòô BÀŘ', false, 'UTF-8'],
            [false, 'foo bar', 'bar', true],
            [false, 'foo bar', 'foo bars', true],
            [false, 'FOO bar', 'foo bars', true],
            [false, 'FOO bars', 'foo BAR', true],
            // [false, 'FÒÔ bàřs', 'fòô bàř', true, 'UTF-8'],
            // [false, 'fòô bàřs', 'fòô BÀŘ', true, 'UTF-8'],
        ] as [$expected, $string, $substring, $caseSensitive]) {
            $this->assertSame($expected, Str::startsWith($string, $substring, $caseSensitive));
        }
    }

    /** @test */
    function it_can_tidy_a_string()
    {
        foreach ([
            ['""', '“”'],
            ["''", '‘’'],
            ['...', '…'],
            ['-', '—'],
        ] as [$expected, $input]) {
            $this->assertSame($expected, Str::tidy($input));
        }
    }

    /** @test */
    function it_can_trim_strings()
    {
        foreach ([
            ['foo   bar', '  foo   bar  '],
            ['foo bar', ' foo bar'],
            ['foo bar', 'foo bar '],
            ['foo bar', "\n\t foo bar \n\t"],
            ['fòô   bàř', '  fòô   bàř  '],
            ['fòô bàř', ' fòô bàř'],
            ['fòô bàř', 'fòô bàř '],
            // @todo ???
            // [' foo bar ', "\n\t foo bar \n\t", "\n\t"],
            // ['fòô bàř', "\n\t fòô bàř \n\t", null, 'UTF-8'],
            // ['fòô', ' fòô ', null, 'UTF-8'], // narrow no-break space (U+202F)
            // ['fòô', '  fòô  ', null, 'UTF-8'], // medium mathematical space (U+205F)
            // ['fòô', '           fòô', null, 'UTF-8'] // spaces U+2000 to U+200A
        ] as [$expected, $input]) {
            $this->assertSame($expected, Str::trim($input));
        }
    }
}
