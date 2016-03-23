<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckoutCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('branch:checkout')
            ->addArgument(
                'code',
                InputArgument::REQUIRED,
                'The issueNumber you want to fix'
            )
            ->addOption(
                'create',
                null,
                InputOption::VALUE_NONE,
                'If set, the branch will be created if not exists.'
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

        if ($this->isBranchExists($issue) && !$input->getOption('create')) {
            $this->runProcess($this->getCheckoutBranchProcess($issue));

            $output->writeln(
                sprintf(
                    "<info>Succesfully checked out '%s'.</info>", $this->getBranchSlug($issue)
                )
            );
        }

        if (!$this->isBranchExists($issue) && $input->getOption('create')) {
            $this->runProcess($this->getCreateBranchProcess($issue));

            $output->writeln(
                sprintf(
                    "<info>Succesfully created & checked out '%s'.</info>", $this->getBranchSlug($issue)
                )
            );
        }
    }
}
