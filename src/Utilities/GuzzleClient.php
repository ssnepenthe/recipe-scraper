<?php

namespace SSNepenthe\RecipeParser\Utilities;

use GuzzleHttp\Client;
use SSNepenthe\RecipeParser\Contracts\HttpClientInterface as Http;

class GuzzleClient implements Http {
	protected $client;

	public function __construct() {
		$this->client = new Client;
	}

	public function get( $url ) {
		$response = $this->client->get( $url );

		return (string) $response->getBody();
	}
}
