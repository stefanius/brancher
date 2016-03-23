<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class BrancherCommand extends BaseCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('branch:create')
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
    }
}
