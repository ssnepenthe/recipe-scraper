<?php

namespace SSNepenthe\RecipeParser\Cache;

use Doctrine\Common\Cache\FilesystemCache;
use SSNepenthe\RecipeParser\Interfaces\CacheInterface;

class DoctrineFSCache implements CacheInterface {
	protected $cache;

	public function __construct( $cache_dir ) {
		$cache_dir = realpath( $cache_dir );

		if ( ! is_dir( $cache_dir ) || ! is_writable( $cache_dir ) ) {
			throw new \RuntimeException(
				'Supplied cache directory is not valid or not writable.'
			);
		}

		$this->cache = new FilesystemCache( $cache_dir );
	}

	public function fetch( $id ) {
		return $this->cache->fetch( $id );
	}

	public function flush() {
		return $this->cache->flushAll();
	}

	public function save( $id, $data, $lifetime = 60 * 60 * 24 ) {
		return $this->cache->save( $id, $data, $lifetime );
	}
}
