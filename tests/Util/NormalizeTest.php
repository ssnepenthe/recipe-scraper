<?php

use SSNepenthe\RecipeParser\Util\Normalize;

/**
 * @todo Some more thorough testing plus documentation about which sites use
 *       which formats on the various methods.
 */
class NormalizeTest extends PHPUnit_Framework_TestCase
{
    public function test_strip_capital_by_from_author()
    {
        $this->assertEquals('Bob Smith', Normalize::author('By Bob Smith'));
    }

    public function test_strip_lowercase_by_from_author()
    {
        $this->assertEquals('Bob Smith', Normalize::author('by Bob Smith'));
    }

    public function test_strip_punctuation_from_author()
    {
        $this->assertEquals('Bob Smith', Normalize::author('By: Bob Smith.'));
    }

    public function test_remove_colon_from_group_title()
    {
        $this->assertEquals('Patties', Normalize::groupTitle('Patties:'));
    }

    public function test_replace_all_non_system_eol_characters()
    {
        $characters = ["\n", "\r", "\r\n"];
        $system = [PHP_EOL];

        $characters = array_diff($characters, $system);
        $pattern = sprintf('/%s/', implode('|', $characters));

        $string = Normalize::EOL(
            "Just Some\rMulti Line\nText To\r\nTest Against"
        );

        $this->assertNotRegExp($pattern, $string);
    }

    public function test_replace_all_fractions()
    {
        $tests = [
            '⅛' => '1/8',
            '¼' => '1/4',
            '⅓' => '1/3',
            '⅜' => '3/8',
            '½' => '1/2',
            '⅝' => '5/8',
            '⅔' => '2/3',
            '¾' => '3/4',
            '⅞' => '7/8',
        ];

        foreach ($tests as $fraction => $numbers) {
            $this->assertEquals($numbers, Normalize::fractions($fraction));
        }
    }

    public function test_add_a_space_before_fractions()
    {
        $string = Normalize::fractions('1⅛ cup');

        $this->assertEquals('1 1/8 cup', $string);
    }

    public function test_replace_words_with_numbers()
    {
        $tests = [
            'twenty' => '20',
            'nineteen' => '19',
            'eighteen' => '18',
            'seventeen' => '17',
            'sixteen' => '16',
            'fifteen' => '15',
            'fourteen' => '14',
            'thirteen' => '13',
            'twelve' => '12',
            'eleven' => '11',
            'ten' => '10',
            'nine' => '9',
            'eight' => '8',
            'seven' => '7',
            'six' => '6',
            'five' => '5',
            'four' => '4',
            'three' => '3',
            'two' => '2',
            'one' => '1',
        ];

        foreach ($tests as $word => $number) {
            $this->assertEquals($number, Normalize::numbers($word));
        }
    }

    public function test_remove_leading_numbers()
    {
        $this->assertEquals('Step One', Normalize::orderedList('1. Step One'));
    }

    public function test_normalize_space_characters()
    {
        $characters = [
            "&nbsp;", "&#160;", "\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81",
            "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85",
            "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89",
            "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"
        ];

        $string = implode('', $characters);

        $this->assertEquals(' ', Normalize::spaces($string));
    }

    /**
     * whiteSpace untested since it is just a wrapper for space + eol.
     */

    public function test_strip_yield_from_recipe_yield()
    {
        $this->assertEquals('1', Normalize::recipeYield('Yield: 1'));
        $this->assertEquals('1', Normalize::recipeYield('Yield 1'));
    }

    public function test_strip_makes_from_recipe_yield()
    {
        $this->assertEquals('2', Normalize::recipeYield('Makes 2'));
        $this->assertEquals('2', Normalize::recipeYield('Makes: 2'));
    }

    public function test_strip_serves_from_recipe_yield()
    {
        $this->assertEquals('3', Normalize::recipeYield('Serves: 3'));
        $this->assertEquals('3', Normalize::recipeYield('Serves 3'));
    }

    public function test_strips_serving_from_recipe_yield()
    {
        $this->assertEquals('1', Normalize::recipeYield('1 serving'));
        $this->assertEquals('1', Normalize::recipeYield('1 Serving'));
        $this->assertEquals('4', Normalize::recipeYield('4 servings'));
        $this->assertEquals('4', Normalize::recipeYield('4 Servings'));
    }

    /**
     * @todo ascii?
     */
}
