<?php

use SSNepenthe\RecipeScraper\Normalizers\SplitOnComma;

class SplitOnCommaTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new SplitOnComma;
    }

    public function test_split_single_list()
    {
        $this->assertEquals(
            ['One', 'Two', 'Three'],
            $this->normalizer->normalize(['One, Two, Three'])
        );
    }

    public function test_split_multple_lists()
    {
        $this->assertEquals(
            ['One', 'Two', 'Three', 'Four', 'Five'],
            $this->normalizer->normalize(['One, Two, Three', 'Four, Five'])
        );
    }
}
