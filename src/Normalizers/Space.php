<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Space implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            $v = str_replace(['&nbsp;', '&#160;'], ' ', $v);

            $search = [
                "\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82",
                "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86",
                "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A",
                "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"
            ];

            $v = str_replace($search, ' ', $v);
            $v = preg_replace('/\h{2,}/', ' ', $v);

            return trim($v);
        }, $values);
    }
}
