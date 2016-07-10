<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class SplitOnComma implements Normalizer {
    public function normalize(array $values) {
        $normalized = [];
        $values = array_map(function($v) {
            $v = array_map(
                'trim',
                explode(',', $v)
            );

            return array_values(array_filter($v));
        }, $values);

        foreach ($values as $value) {
            $normalized = array_merge(
                $normalized,
                $value
            );
        }

        return array_values(array_filter($normalized));
    }
}
