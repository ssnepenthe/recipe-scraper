<?php

namespace RecipeScraperTests;

use RecipeScraper\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
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
}
