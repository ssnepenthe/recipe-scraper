<?php

use SSNepenthe\RecipeScraper\Transformers\StringsToIntervals;

class StringsToIntervalsTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new StringsToIntervals;
	}

	public function test_transform_single_item()
	{
		$this->assertEquals(
			[new DateInterval('PT20M')],
			$this->transformer->transform(['PT20M'])
		);
	}

	public function test_transform_multiple_items()
	{
		$this->assertEquals(
			[new DateInterval('PT1H5M'), new DateInterval('PT10M')],
			$this->transformer->transform(['PT1H5M', 'PT10M'])
		);
	}

	public function test_filter_out_unrecognizable_interval_strings()
	{
		$this->assertEquals(
			[new DateInterval('PT7M')],
			$this->transformer->transform(['Bad Interval String', 'PT7M'])
		);
	}

	public function test_return_empty_array_if_no_valid_intervals_provided()
	{
		$this->assertEquals(
			[],
			$this->transformer->transform(['Bad', 'Interval', 'Strings'])
		);
	}

	public function test_strip_title_flags()
	{
		$this->assertEquals(
			[new DateInterval('PT10M')],
			$this->transformer->transform(['%%TITLE%%PT10M%%TITLE%%'])
		);
	}
}
