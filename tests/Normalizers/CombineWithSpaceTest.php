<?php

use SSNepenthe\RecipeScraper\Normalizers\CombineWithSpace;

class CombineWithSpaceTest extends PHPUnit_Framework_TestCase
{
	protected $normalizer;

	public function setUp()
	{
		$this->normalizer = new CombineWithSpace;
	}

	public function test_normalize_list()
	{
		$this->assertEquals(
			['One. Two. Three.'],
			$this->normalizer->normalize(['One.', 'Two.', 'Three.'])
		);
	}
}
