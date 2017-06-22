<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UrlRemoveCommand extends Command
{
    use UsesTestData;

    protected $template = "<?php

return %s;
";

    protected function configure()
    {
        $this->setName('url:remove')
            ->setDescription('Remove a URL from the list of tested URLs')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to remove');
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

        if (false !== $key = array_search($url, $urlList)) {
            unset($urlList[$key]);
            $urlList = array_values($urlList);
        }

        if ($output->isDebug()) {
            $io->block('URL: ' . $url, 'DEBUG');
            $io->block('URL host: ' . $host, 'DEBUG');
            $io->block('URL list file: ' . $urlListFile, 'DEBUG');
            $io->block('URL list: ' . var_export($urlList, true), 'DEBUG');
        }

        if (! empty($urlList)) {
            file_put_contents($urlListFile, sprintf($this->template, var_export($urlList, true)));
        } elseif ($exists) {
            unlink($urlListFile);
        }
    }
}
