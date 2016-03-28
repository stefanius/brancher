<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('create')
            ->addArgument(
                'code',
                InputArgument::REQUIRED,
                'The issueNumber you want to fix'
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
            throw new \Exception(
                sprintf(
                    "Branch '%s' already exists. You can check it out or delete it before create a new one.",
                    $this->getBranchSlug($issue)
                )
            );
        }

        $this->runProcess($this->getCreateBranchProcess($issue));

        $output->writeln(sprintf("<info>Branch '%s' successful created</info>", $this->getBranchSlug($issue)));
    }
}
