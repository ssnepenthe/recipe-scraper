<?php

class CreativeWorkTest extends PHPUnit_Framework_TestCase
{
    protected $creative_work;
    protected $props = ['author', 'publisher'];

    protected function setUp()
    {
        $this->creative_work = new SSNepenthe\RecipeScraper\Schema\CreativeWork;
    }

    public function test_correctly_set_up_properties()
    {
        foreach ($this->props as $property) {
            $this->assertContains($property, $this->creative_work->getKeys());
        }
    }
}
