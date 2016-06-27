<?php

use SSNepenthe\RecipeParser\Util\Format;

class FormatTest extends PHPUnit_Framework_TestCase
{
    public function test_format_line()
    {
        $this->assertEquals(
            'Line 1 Line 2',
            Format::line(' Line 1' . PHP_EOL . 'Line 2 ')
        );
    }

    public function test_list_from_line()
    {
        $this->assertEquals(
            ['Line 1', 'Line 2'],
            Format::listFromLine(' Line 1' . PHP_EOL . 'Line 2 ')
        );
    }
}
