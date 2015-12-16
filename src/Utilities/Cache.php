<?php

namespace SSNepenthe\RecipeParser\Utilities;

use Doctrine\Common\Cache\FilesystemCache;
use SSNepenthe\RecipeParser\Contracts\CacheInterface;

class Cache implements CacheInterface {
	protected $cache;

	public function __construct() {
		$this->cache = new FilesystemCache( dirname( dirname( __DIR__ ) ) . '/the-cache' );
	}

	public function fetch( $id ) {
		return $this->cache->fetch( $id );
	}

	public function save( $id, $data, $lifetime = 0 ) {
		return $this->cache->save( $id, $data, $lifetime );
	}

	public function contains( $id ) {
		return $this->cache->contains( $id );
	}
}
