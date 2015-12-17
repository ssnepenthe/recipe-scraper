<?php

namespace SSNepenthe\RecipeParser;

use Exception;
use SSNepenthe\RecipeParser\Contracts\CacheInterface as Cache;
use SSNepenthe\RecipeParser\Contracts\HttpClientInterface as Http;
use SSNepenthe\RecipeParser\Exception\NoMatchingParserException;

class RecipeParser {
	protected $cache;

	protected $parser;

	protected $site_parsers = [
		'allrecipes.com'      => 'SSNepenthe\\RecipeParser\\Parsers\\AllRecipesCom',
		'bettycrocker.com'    => 'SSNepenthe\\RecipeParser\\Parsers\\BettyCrockerCom',
		'bhg.com'             => 'SSNepenthe\\RecipeParser\\Parsers\\BHGCom',
		'delish.com'          => 'SSNepenthe\\RecipeParser\\Parsers\\DelishCom',
		'epicurious.com'      => 'SSNepenthe\\RecipeParser\\Parsers\\EpicuriousCom',
		'farmflavor.com'      => 'SSNepenthe\\RecipeParser\\Parsers\\FarmFlavorCom',
		'food.com'            => 'SSNepenthe\\RecipeParser\\Parsers\\FoodCom',
		'foodandwine.com'     => 'SSNepenthe\\RecipeParser\\Parsers\\FoodAndWineCom',
		'foodnetwork.com'     => 'SSNepenthe\\RecipeParser\\Parsers\\FoodNetworkCom',
		'marthastewart.com'   => 'SSNepenthe\\RecipeParser\\Parsers\\MarthaStewartCom',
		'myrecipes.com'       => 'SSNepenthe\\RecipeParser\\Parsers\\MyRecipesCom',
		'pauladeen.com'       => 'SSNepenthe\\RecipeParser\\Parsers\\PaulaDeenCom',
		'tablespoon.com'      => 'SSNepenthe\\RecipeParser\\Parsers\\TablespoonCom',
		'tasteofhome.com'     => 'SSNepenthe\\RecipeParser\\Parsers\\TasteOfHomeCom',
		'thepioneerwoman.com' => 'SSNepenthe\\RecipeParser\\Parsers\\ThePioneerWomanCom',
	];

	protected $markup_parsers = [
		'http://data-vocabulary.org/Recipe' => 'SSNepenthe\\RecipeParser\\Parsers\\DataVocabularyOrg',
		'http://schema.org/Recipe'          => 'SSNepenthe\\RecipeParser\\Parsers\\SchemaOrg',
	];

	protected $url;

	public function __construct( $url, Http $client, Cache $cache ) {
		$this->cache  = $cache;
		$this->client = $client;
		$this->url    = $url;
	}

	public function get_markup_parser( $html ) {
		foreach ( $this->markup_parsers as $search => $class ) {
			if ( stripos( $html, $search ) ) {
				return $class;
			}
		}

		return false;
	}

	public function get_site_parser( $id ) {
		// Subdomains?
		if ( isset( $this->site_parsers[ $id ] ) ) {
			return $this->site_parsers[ $id ];
		}

		return false;
	}

	public function parse() {
		$html = $this->http_get_and_cache();

		$host = strtolower( parse_url( $this->url, PHP_URL_HOST ) );

		if ( 0 === strpos( $host, 'www.' ) ) {
			$host = substr( $host, 4 );
		}

		if ( $class = $this->get_site_parser( $host ) ) {
			$this->parser = new $class( $html );

			return $this->parser->parse();
		}

		if ( $class = $this->get_markup_parser( $html ) ) {
			$this->parser = new $class( $html );

			return $this->parser->parse();
		}

		throw new NoMatchingParserException( 'No parser found for this recipe' );
	}

	protected function http_get() {
		return $this->client->get( $this->url );
	}

	protected function http_get_and_cache() {
		if ( ! $response = $this->cache->fetch( $this->url ) ) {
			$response = $this->http_get();

			$this->cache->save( $this->url, $response, 60 * 60 * 24 );
		}

		return $response;
	}
}
