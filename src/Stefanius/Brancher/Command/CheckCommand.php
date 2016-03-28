<?php

namespace Stefanius\Brancher\Command;

use Stefanius\Brancher\Checker\Checker;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('check')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $checker = new Checker($this->parameters->getWorkingDir());

        if ($checker->isOk()) {
            $output->writeln(
                sprintf(
                    '<info>The path \'%s\' is a valid repository that Brancher can use.</info>',
                    $this->parameters->getWorkingDir()
                )
            );
        }
    }
}
