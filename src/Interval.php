<?php

namespace RecipeScraper;

use DateTime;
use Exception;
use DateInterval;
use InvalidArgumentException;

class Interval
{
    /**
     * @param  string $string
     * @return DateInterval
     */
    public static function fromString(string $string) : DateInterval
    {
        $interval = null;

        try {
            // First try standard spec.
            $interval = new DateInterval($string);
        } catch (Exception $e) {
            // And fall back to relative time string.
            // Error suppression necessary as of https://github.com/php/php-src/commit/a890c5beb8327b7fbb2f25347256ef0dc5809750.
            $interval = @DateInterval::createFromDateString($string);
        }

        if (! $interval instanceof DateInterval) {
            $interval = new DateInterval('PT0H');
        }

        if (static::isEmpty($interval)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid interval string [%s] provided in %s',
                $string,
                __METHOD__
            ));
        }

        return static::recalculateCarryOver($interval);
    }

    /**
     * @param  DateInterval $interval
     * @return string
     */
    public static function toIso8601(DateInterval $interval) : string
    {
        $format = 'P';

        if ($interval->y) {
            $format .= '%yY';
        }

        if ($interval->m) {
            $format .= '%mM';
        }

        if ($interval->d) {
            $format .= '%dD';
        }

        if ($interval->h || $interval->i || $interval->s) {
            $format .= 'T';
        }

        if ($interval->h) {
            $format .= '%hH';
        }

        if ($interval->i) {
            $format .= '%iM';
        }

        if ($interval->s) {
            $format .= '%sS';
        }

        return $interval->format($format);
    }

    /**
     * @param  DateInterval $interval
     * @return boolean
     */
    public static function isEmpty(DateInterval $interval) : bool
    {
        return ! $interval->y
            && ! $interval->m
            && ! $interval->d
            && ! $interval->h
            && ! $interval->i
            && ! $interval->s;
    }

    /**
     * @param  DateInterval $interval
     * @return DateInterval
     */
    public static function recalculateCarryOver(DateInterval $interval) : DateInterval
    {
        $dt1 = new DateTime;
        $dt2 = clone $dt1;

        $dt2->add($interval);

        return $dt1->diff($dt2);
    }

    /**
     * @param  string $intervalString
     * @return string
     */
    public static function normalize(string $intervalString) : string
    {
        try {
            return static::toIso8601(static::fromString($intervalString));
        } catch (\Exception $e) {
            // Invalid or empty interval.
            return '';
        }
    }
}
