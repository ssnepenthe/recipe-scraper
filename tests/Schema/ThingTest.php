<?php

class ThingTest extends PHPUnit_Framework_TestCase
{
    protected $thing;
    protected $props = ['description', 'image', 'name', 'url'];

    protected function setUp()
    {
        $this->thing = new SSNepenthe\RecipeParser\Schema\Thing;
    }

    public function test_correctly_set_up_properties()
    {
        $this->assertEquals(
            $this->props,
            $this->thing->getKeys()
        );
    }

    public function test_correctly_set_text()
    {
        $description = 'Just a simple description.';

        $this->thing->setDescription($description);

        $this->assertEquals(
            $description,
            $this->thing->description
        );
    }

    public function test_throw_exception_when_text_is_not_a_string()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->thing->setDescription(4);
    }
}
