<?php

namespace SSNepenthe\RecipeScraper;

use DateInterval;

class Interval
{
    public static function fromString($string)
    {
        try {
            // First try standard spec.
            $interval = new DateInterval($string);
        } catch (\Exception $e) {
            // And fall back to relative time string.
            $interval = DateInterval::createFromDateString($string);
        }

        if (static::isEmpty($interval)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid interval string [%s] provided in %s',
                $string,
                __METHOD__
            ));
        }

        return static::recalculateCarryOver($interval);
    }

    public static function toIso8601(DateInterval $interval)
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

    public static function isEmpty(DateInterval $interval)
    {
        return ! $interval->y
            && ! $interval->m
            && ! $interval->d
            && ! $interval->h
            && ! $interval->i
            && ! $interval->s;
    }

    public static function recalculateCarryOver(DateInterval $interval)
    {
        $dt1 = new \DateTime;
        $dt2 = clone $dt1;

        $dt2->add($interval);

        return $dt1->diff($dt2);
    }
}
