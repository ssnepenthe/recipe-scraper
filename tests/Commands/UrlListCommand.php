<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UrlListCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('url:list')
            ->setDescription('List all test URLs for a given host')
            ->addArgument('host', InputArgument::OPTIONAL, 'The host to list test URLs for');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $input->getArgument('host');

        if ($host) {
            $urlListFile = $this->getUrlsDataFilePath($host);

            if (! file_exists($urlListFile)) {
                throw new \InvalidArgumentException(sprintf(
                    'URL list file [%s] for provided host [%s] does not exist',
                    $urlListFile,
                    $host
                ));
            }

            $urlList = (array) static::includeFile($urlListFile);
        } else {
            $urlList = $this->getTestUrls();
        }

        $io = new SymfonyStyle($input, $output);

        if ($output->isDebug() && $host) {
            $io->block('Host: ' . $host, 'DEBUG');
            $io->block('URL list file: ' . $urlListFile, 'DEBUG');
        }

        $io->note(sprintf('%s URLs Total', count($urlList)));
        $io->listing($urlList);
    }
}
