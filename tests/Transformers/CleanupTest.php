<?php

use SSNepenthe\RecipeScraper\Transformers\Cleanup;

class CleanupTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new Cleanup;
	}

	public function test_strip_title_flags()
	{
		$this->assertEquals(
			['Test'],
			$this->transformer->transform(['%%TITLE%% Test %%TITLE%%'])
		);
	}
}
