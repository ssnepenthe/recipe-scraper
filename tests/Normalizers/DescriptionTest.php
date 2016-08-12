<?php

use SSNepenthe\RecipeScraper\Normalizers\Description;

class DescriptionTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Description;
    }

    public function test_strip_read_mode()
    {
        $this->assertEquals(
            ['Chicken teriyaki makes a weekly appearance in my home, whether it\'s via the slow cooker, in the form of meatballs or as the stellar sauce atop crispy baked chicken wings. And with the perfect homemade teriyaki sauce in tote, it\'s time to wave goodbye to that bottled stuff and say hello to my go-to tips for successful teriyaki chicken stir-fry.'],
            $this->normalizer->normalize(['Chicken teriyaki makes a weekly appearance in my home, whether it\'s via the slow cooker, in the form of meatballs or as the stellar sauce atop crispy baked chicken wings. And with the perfect homemade teriyaki sauce in tote, it\'s time to wave goodbye to that bottled stuff and say hello to my go-to tips for successful teriyaki chicken stir-fry. [Get the Recipe…]'])
        );
    }
}
