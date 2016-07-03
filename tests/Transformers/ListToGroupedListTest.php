<?php

use SSNepenthe\RecipeScraper\Transformers\ListToGroupedList;

class ListToGroupedListTest extends PHPUnit_Framework_TestCase
{
	protected $transformer;

	public function setUp()
	{
		$this->transformer = new ListToGroupedList;
	}

	public function test_transform_single_group()
	{
		$list = [
			'Burgers:',
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
		];
		$grouped = [
			[
				'title' => 'Burgers',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}

	public function test_transform_single_untitled_group()
	{
		$list = [
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
		];
		$grouped = [
			[
				'title' => '',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}

	public function test_transform_multiple_groups()
	{
		$list = [
			'Burgers:',
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
			'Corn:',
			'4 ears sweet corn',
			'1/2 cup unsalted butter',
			'1/4 cup fresh terragon, diced',
		];
		$grouped = [
			[
				'title' => 'Burgers',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
			[
				'title' => 'Corn',
				'data' => [
					'4 ears sweet corn',
					'1/2 cup unsalted butter',
					'1/4 cup fresh terragon, diced',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}

	public function test_transform_multiple_groups_with_no_title_for_first()
	{
		$list = [
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
			'Corn:',
			'4 ears sweet corn',
			'1/2 cup unsalted butter',
			'1/4 cup fresh terragon, diced',
		];
		$grouped = [
			[
				'title' => '',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
			[
				'title' => 'Corn',
				'data' => [
					'4 ears sweet corn',
					'1/2 cup unsalted butter',
					'1/4 cup fresh terragon, diced',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}

	public function test_recognize_colon_title()
	{
		$list = [
			'Burgers:',
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
		];
		$grouped = [
			[
				'title' => 'Burgers',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}

	public function test_recognize_all_caps_title()
	{
		$list = [
			'BURGERS',
			'1 lb ground chuck',
			'1 tbsp onion powder',
			'1 tbsp garlic powder',
			'1 tbsp freshly cracked black pepper',
		];
		$grouped = [
			[
				'title' => 'Burgers',
				'data' => [
					'1 lb ground chuck',
					'1 tbsp onion powder',
					'1 tbsp garlic powder',
					'1 tbsp freshly cracked black pepper',
				],
			],
		];

		$this->assertEquals($grouped, $this->transformer->transform($list));
	}
}
