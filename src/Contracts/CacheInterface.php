<?php

namespace SSNepenthe\RecipeParser\Contracts;

interface CacheInterface {
	public function fetch( $id );

	public function save( $id, $data, $lifetime );
}
