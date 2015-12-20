<?php

namespace SSNepenthe\RecipeParser\Utilities;

use Doctrine\Common\Cache\FilesystemCache;
use SSNepenthe\RecipeParser\Contracts\CacheInterface;

class Cache implements CacheInterface {
	protected $cache;

	public function __construct( $cache = null ) {
		if ( is_null( $cache ) ) {
			$cache = dirname( dirname( __DIR__ ) ) . '/cache';
		}

		$cache = realpath( $cache );

		if ( ! is_dir( $cache ) && is_writable( $cache ) ) {
			throw new RuntimeException( 'Supplied cache directory is not valid or not writable' );
		}

		$this->cache = new FilesystemCache( $cache );
	}

	public function fetch( $id ) {
		return $this->cache->fetch( $id );
	}

	public function save( $id, $data, $lifetime = 0 ) {
		return $this->cache->save( $id, $data, $lifetime );
	}
}
