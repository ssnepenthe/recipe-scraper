<?php

namespace SSNepenthe\RecipeParser\Console\Command;

use SSNepenthe\RecipeParser\Cache\DoctrineFSCache as Cache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends Command
{
    public function configure()
    {
        $this->setName('clear-cache')
            ->setDescription('Clear the recipe parser cache.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // @todo Think about sharing cache between commands...
        $cache = new Cache(
            sprintf('%s/.cache', dirname(dirname(dirname(( __DIR__ )))))
        );

        // @todo Provide some on-screen feedback so user knows what is happening.
        $cache->flush();
    }
}
