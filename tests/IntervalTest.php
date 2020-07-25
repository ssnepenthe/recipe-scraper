<?php

namespace RecipeScraperTests;

use DateInterval;
use RecipeScraper\Interval;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IntervalTest extends TestCase
{
    /** @test */
    function it_can_create_intervals_using_standard_interval_spec()
    {
        $this->assertEquals(
            new DateInterval('PT30M'),
            Interval::fromString('PT30M')
        );
    }

    /** @test */
    function it_can_create_intervals_from_relative_interval_strings()
    {
        $this->assertEquals(
            new DateInterval('PT30M'),
            Interval::fromString('30 minutes')
        );
    }

    /** @test */
    function it_throws_for_bad_interval_strings()
    {
        $this->expectException(InvalidArgumentException::class);

        Interval::fromString('not an interval');
    }

    /** @test */
    function it_automatically_recalculates_carry_over()
    {
        $this->assertEquals(
            new DateInterval('PT1H15M'),
            Interval::fromString('PT75M')
        );
    }

    /** @test */
    function it_can_format_interval_as_iso_8601()
    {
        $this->assertEquals(
            'PT30M',
            Interval::toIso8601(new DateInterval('PT30M'))
        );
        $this->assertEquals(
            'PT1H20M',
            Interval::toIso8601(new DateInterval('PT1H20M'))
        );
        $this->assertEquals(
            'P1DT14H25M55S',
            Interval::toIso8601(new DateInterval('P1DT14H25M55S'))
        );
    }

    /** @test */
    function it_knows_when_an_interval_is_empty()
    {
        $this->assertTrue(
            Interval::isEmpty(DateInterval::createFromDateString('0 minutes'))
        );
        $this->assertFalse(Interval::isEmpty(
            DateInterval::createFromDateString('55 minutes')
        ));
    }

    /** @test */
    function it_can_recalculate_carry_over()
    {
        $this->assertEquals(
            new DateInterval('PT2H25M'),
            Interval::recalculateCarryOver(new DateInterval('PT145M'))
        );
    }
}
