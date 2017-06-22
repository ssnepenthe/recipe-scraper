<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UrlAddCommand extends Command
{
    use UsesTestData;

    protected $template = "<?php

return %s;
";

    protected function configure()
    {
        $this->setName('url:add')
            ->setDescription('Add a URL to the list of tested URLs')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to add');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $host = parse_url($url, PHP_URL_HOST);

        if (! $host) {
            throw new \InvalidArgumentException(sprintf(
                'Supplied URL [%s] does not appear to be valid',
                $url
            ));
        }

        $io = new SymfonyStyle($input, $output);

        $urlListFile = $this->getUrlsDataFilePath($host);
        $urlList = [];
        $exists = file_exists($urlListFile);

        if ($exists) {
            $urlList = (array) static::includeFile($urlListFile);
        }

        if (false === array_search($url, $urlList)) {
            $urlList[] = $url;
        }

        if ($output->isDebug()) {
            $io->block('URL: ' . $url, 'DEBUG');
            $io->block('URL host: ' . $host, 'DEBUG');
            $io->block('URL list file: ' . $urlListFile, 'DEBUG');
            $io->block('URL list: ' . var_export($urlList, true), 'DEBUG');
        }

        file_put_contents($urlListFile, sprintf($this->template, var_export($urlList, true)));
    }
}
