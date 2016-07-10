<?php

use SSNepenthe\RecipeScraper\Transformers\NullTransformer;

class NullTransformerTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new NullTransformer;
	}

	public function test_transform_list()
	{
		$value = ['One.', 'Two.', 'Three.'];
		$this->assertEquals($value, $this->transformer->transform($value));
	}
}
