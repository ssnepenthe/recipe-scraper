<?php

namespace SSNepenthe\RecipeParser\Contracts;

interface HttpClientInterface {
	public function get( $url );
}
