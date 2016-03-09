<?php

namespace Stefanius\Brancher\Command;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\JiraAdapter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class BrancherCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('brancher:do')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = Yaml::parse(file_get_contents('/Users/sgrootveld/PhpstormProjects/brancher/.brancher'));

        $client = new Client();

        $jira = new JiraAdapter($client, $config['jira']);
        $jira->find('TMV-404');
    }
}