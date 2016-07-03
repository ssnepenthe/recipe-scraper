<?php

use SSNepenthe\RecipeScraper\Transformers\ItemToLine;

class ItemToLineTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new ItemToLine;
	}

	public function test_transform_single_item()
	{
		$this->assertEquals(
			['One. Two. Three.'],
			$this->transformer->transform(
				[sprintf('One.%1$sTwo.%1$sThree.', PHP_EOL)]
			)
		);
	}

	public function test_transform_multiple_items()
	{
		$this->assertEquals(
			[
				'One. Two. Three.',
				'Four. Five.',
				'Six Seven Eight',
			],
			$this->transformer->transform([
				sprintf('One.%1$sTwo.%1$sThree.', PHP_EOL),
				sprintf('Four.%1$sFive.', PHP_EOL),
				sprintf('Six%1$sSeven%1$sEight', PHP_EOL),
			])
		);
	}
}
