<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class BrancherCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('brancher:do')
            ->addArgument(
                'code',
                InputArgument::REQUIRED,
                'The issueNumber you want to fix'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adapter = $this->buildAdapter();
        $issue = $adapter->find($input->getArgument('code'));

        $slug = $this->getSlugifier()->manipulate($issue->getCode() . '-' . $issue->getTitle());

        $process = new Process('git checkout -b ' . $slug);
        $process->run();
    }
}