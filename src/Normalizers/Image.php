<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Image implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            // Trim leading slashes from image URL (i.e. relative images).
            $v = trim($v, "/ \t\n\r\0\x0B");

            // @todo Determine whether it should be http or https.
            if ('http' !== substr($v, 0, 4)) {
                $v = 'http://' . $v;
            }

            return $v;
        }, $values);
    }
}
