<?php

namespace SSNepenthe\RecipeParser\Console\Command;

use SSNepenthe\RecipeParser\ParserLocator;
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

        if (! $html = $cache->fetch($url)) {
            $html = $http->get($url);

            $cache->save($url, $html);
        }

        $locator = new ParserLocator($url, $html);
        $located = $locator->locate();

        if (! $output->isQuiet()) {
            $parser = new $located($html);

            $recipe = $parser->parse($url);

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
