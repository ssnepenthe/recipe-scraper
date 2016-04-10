<?php

namespace SSNepenthe\RecipeParser\Interfaces;

interface CacheInterface {
	public function fetch( $id );

	public function flush();

	public function save( $id, $data, $lifetime );
}
