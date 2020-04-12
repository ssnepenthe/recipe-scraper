<?php
require 'vendor/autoload.php';

use Goutte\Client;

$scraper = \RecipeScraper\Factory::make();
$client = new Client();
$url = 'http://allrecipes.com/recipe/139917/joses-shrimp-ceviche/';
$crawler = $client->request('GET', $url);

if ($scraper->supports($crawler)) {
    var_dump($scraper->scrape($crawler));
} else {
    var_dump("{$url} not currently supported!");
}
