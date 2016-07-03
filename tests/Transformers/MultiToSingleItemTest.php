<?php

use SSNepenthe\RecipeScraper\Transformers\MultiToSingleItem;

class MultiToSingleItemTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new MultiToSingleItem;
	}

	public function test_transform_list()
	{
		$this->assertEquals(
			['One. Two. Three.'],
			$this->transformer->transform(['One.', 'Two.', 'Three.'])
		);
	}
}
