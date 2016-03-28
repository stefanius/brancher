<?php

namespace Stefanius\Brancher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckoutCommand extends BaseCommand
{
    const CREATE_OPTION = 'create';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('checkout')
            ->addArgument(
                'code',
                InputArgument::REQUIRED,
                'The issueNumber you want to fix'
            )
            ->addOption(
                self::CREATE_OPTION,
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

        if ($this->isBranchExists($issue) && !$input->getOption(self::CREATE_OPTION)) {
            $this->runProcess($this->getCheckoutBranchProcess($issue));

            $output->writeln(
                sprintf(
                    "<info>Succesfully checked out '%s'.</info>", $this->getBranchSlug($issue)
                )
            );

            return;
        }

        if (!$this->isBranchExists($issue) && $input->getOption(self::CREATE_OPTION)) {
            $this->runProcess($this->getCreateBranchProcess($issue));

            $output->writeln(
                sprintf(
                    "<info>Succesfully created & checked out '%s'.</info>", $this->getBranchSlug($issue)
                )
            );

            return;
        }

        $output->writeln(
            sprintf(
                "<info>" .
                    "Branch '%s' is not checked out. Maybe the branch didn't exists." .
                    "You may want to use the '--create' switch." .
                "</info>",
                $this->getBranchSlug($issue)
            )
        );
    }
}
