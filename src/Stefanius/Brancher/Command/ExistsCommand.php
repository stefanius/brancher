<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExistsCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('exists')
            ->addArgument(
                'code',
                InputArgument::REQUIRED,
                'The issueNumber you want to check for a featurebranch.'
            )
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adapter = $this->buildAdapter();
        $issue = $adapter->find($input->getArgument('code'));

        if ($this->isBranchExists($issue)) {
            $message = sprintf("<info>Branch '%s' exists on your system.</info>", $this->getBranchSlug($issue));
        } else {
            $message = sprintf("<info>Branch '%s' does not exists on your system.</info>", $this->getBranchSlug($issue));
        }

        $output->writeln($message);
    }
}
