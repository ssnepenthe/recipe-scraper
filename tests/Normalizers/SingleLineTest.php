<?php

use SSNepenthe\RecipeScraper\Normalizers\SingleLine;

class SingleLineTest extends PHPUnit_Framework_TestCase
{
	protected $normalizer;

	public function setUp()
	{
		$this->normalizer = new SingleLine;
	}

	public function test_normalize_single_item()
	{
		$this->assertEquals(
			['One. Two. Three.'],
			$this->normalizer->normalize(
				[sprintf('One.%1$sTwo.%1$sThree.', PHP_EOL)]
			)
		);
	}

	public function test_normalize_multiple_items()
	{
		$this->assertEquals(
			[
				'One. Two. Three.',
				'Four. Five.',
				'Six Seven Eight',
			],
			$this->normalizer->normalize([
				sprintf('One.%1$sTwo.%1$sThree.', PHP_EOL),
				sprintf('Four.%1$sFive.', PHP_EOL),
				sprintf('Six%1$sSeven%1$sEight', PHP_EOL),
			])
		);
	}
}
