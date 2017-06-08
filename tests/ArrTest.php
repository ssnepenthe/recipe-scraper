<?php

namespace RecipeScraperTests;

use RecipeScraper\Arr;
use RecipeScraper\Str;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
	/** @test */
	function it_returns_default_it_array_is_invalid()
	{
		$this->assertNull(Arr::get('string', 'key'));
		$this->assertFalse(Arr::get('string', 'key', false));
	}

	/** @test */
	function it_returns_the_full_array_if_key_is_null()
	{
		$arr = ['one' => 'two', 'three' => 'four'];

		$this->assertEquals($arr, Arr::get($arr, null));
	}

	/** @test */
	function it_can_get_items_to_an_arbitrary_depth()
	{
		$arr = [
			'one' => 'two',
			'three' => [
				'four' => 'five',
				'six' => [
					'seven' => 'eight',
					'nine' => 'ten',
				],
			],
		];

		$this->assertEquals('two', Arr::get($arr, 'one'));
		$this->assertEquals('five', Arr::get($arr, 'three.four'));
		$this->assertEquals('eight', Arr::get($arr, 'three.six.seven'));
	}

	/** @test */
	function it_returns_default_if_item_is_not_set()
	{
		$arr = [
			'one' => 'two',
			'three' => [
				'four' => 'five',
				'six' => [
					'seven' => 'eight',
					'nine' => 'ten',
				],
			],
		];

		$this->assertNull(Arr::get($arr, 'two'));
		$this->assertNull(Arr::get($arr, 'three.five'));
		$this->assertNull(Arr::get($arr, 'three.six.eight'));
	}

	/** @test */
	function it_returns_empty_array_when_attempting_to_normalize_non_strings()
	{
		$this->assertEquals([], Arr::normalize(['one' => 1, 'two' => 2]));
	}

	/** @test */
	function it_calls_str_normalize_for_an_array_of_strings()
	{
		$this->assertEquals(
			['&', 'test', 'one two three done'],
			Arr::normalize(['&amp;', ' test ', 'one two  three   done'])
		);
	}

	/** @test */
	function it_can_tell_if_an_array_contains_only_strings()
	{
		$this->assertTrue(Arr::ofStrings(['one', 'two', 'three', 'four']));
		$this->assertTrue(Arr::ofStrings(['one' => 'two', 'three' => 'four']));

		$this->assertFalse(Arr::ofStrings([1, 2, 3, 4]));
		$this->assertFalse(Arr::ofStrings(['one' => 1, 'two' => 2, 'three' => 3]));
	}
}
