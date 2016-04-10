<?php

namespace SSNepenthe\RecipeParser\Console\Command;

use SSNepenthe\RecipeParser\Cache\DoctrineFSCache as Cache;
use SSNepenthe\RecipeParser\Http\CurlClient as Client;
use SSNepenthe\RecipeParser\RecipeParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseCommand extends Command {
	public function configure() {
		$this->setName( 'parse' )
			->setDescription( 'Parse a recipe from the command line.' )
			->addArgument(
				'URL',
				InputArgument::REQUIRED,
				'URL of the recipe you want to parse.'
			);
	}

	public function execute( InputInterface $input, OutputInterface $output ) {
		$url = filter_var( $input->getArgument( 'URL' ), FILTER_SANITIZE_URL );
		$cache = new Cache(
			sprintf( '%s/.cache', dirname( dirname( dirname( ( __DIR__ ) ) ) ) )
		);

		$parser = new RecipeParser( $url, new Client, $cache );

		if ( ! $output->isQuiet() ) {
			$io = new SymfonyStyle( $input, $output );
			$recipe = $parser->parse();

			$io->title(
				$recipe->name ? $recipe->name : 'Untitled Recipe'
			);

			$io->section( 'Meta' );

			$io->text( [
				$recipe->author ?
					sprintf( 'Author: %s.', $recipe->author ) :
					'No author found.',
				$recipe->publisher ?
					sprintf( 'Publisher: %s.', $recipe->publisher ) :
					'No publisher found.',
			] );

			$io->section( 'URLs' );

			$io->text( [
				$recipe->image ?
					sprintf( 'Image: %s.', $recipe->image ) :
					'No image found.',
				$recipe->url ?
					sprintf( 'Recipe: %s', $recipe->url ) :
					'No URL found.',
			] );

			$io->section( 'Description' );

			$io->text(
				$recipe->description ?
					$recipe->description :
					'No description found.'
			);

			$io->section( 'Categories' );

			$io->listing(
				$recipe->categories ?
					$recipe->categories :
					[ 'No categories found' ]
			);

			$io->section( 'Yield' );

			$io->text(
				$recipe->recipe_yield ?
					$recipe->recipe_yield :
					'No yield found.'
			);

			$io->section( 'Timings' );
			$f = '%h hours, %i minutes and %s seconds';

			$io->text( [
				$recipe->cook_time ?
					sprintf( 'Cook Time: %s.', $recipe->cook_time->format( $f ) ) :
					'No cook time found.',
				$recipe->prep_time ?
					sprintf( 'Prep Time: %s.', $recipe->prep_time->format( $f ) ) :
					'No prep time found.',
				$recipe->total_time ?
					sprintf( 'Total Time: %s.', $recipe->total_time->format( $f ) ) :
					'No total time found.',
			] );

			$io->section( 'Ingredients' );

			$io->listing(
				$recipe->recipe_ingredients ?
					$recipe->recipe_ingredients :
					[ 'No ingredients found.' ]
			);

			$io->section( 'Instructions' );

			$io->listing(
				$recipe->recipe_instructions ?
					$recipe->recipe_instructions :
					[ 'No instructions found.' ]
			);
		}
	}
}
