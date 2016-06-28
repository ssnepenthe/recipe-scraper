<?php

namespace SSNepenthe\RecipeParser\Console\Command;

use SSNepenthe\RecipeParser\RecipeParser;
use SSNepenthe\RecipeParser\Http\CurlClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SSNepenthe\RecipeParser\Cache\DoctrineFSCache as Cache;

class ParseCommand extends Command
{
    public function configure()
    {
        $this->setName('parse')
            ->setDescription('Parse a recipe from the command line.')
            ->addArgument(
                'URL',
                InputArgument::REQUIRED,
                'URL of the recipe you want to parse.'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $url = filter_var($input->getArgument('URL'), FILTER_SANITIZE_URL);

        /**
         * @todo Check if we can write to system tmp dir first, fallback to .cache.
         *       Think about sharing cache config beteen commands.
         */
        $cache = new Cache(
            sprintf('%s/.cache', dirname(dirname(dirname(( __DIR__ )))))
        );

        $http = new CurlClient;
        $parser = new RecipeParser($http, $cache);
        $recipe = $parser->parse($url);

        if (! $output->isQuiet()) {
            /**
             * @todo Better looking output.
             *       Also, dump() is from symfony var-dumper which is not an
             *       actual dependency of this project - it is pulled in with
             *       psysh. Psysh is a dev-only dependency.
             */
            dump($recipe);
        }
    }
}
