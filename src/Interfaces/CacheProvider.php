<?php

namespace SSNepenthe\RecipeParser\Interfaces;

interface CacheProvider
{
    public function fetch($id);

    public function flush();

    public function save($id, $data, $lifetime);
}
