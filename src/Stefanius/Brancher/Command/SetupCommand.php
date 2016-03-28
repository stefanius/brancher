<?php

namespace Stefanius\Brancher\Command;

use Stefanius\Brancher\Checker\Checker;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class SetupCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('lib:setup')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $systemQuestion = new ChoiceQuestion(
            'Select your issue system',
            ['jira', 'github']
        );

        $answer = $helper->ask($input, $output, $systemQuestion);
        $configMethod = sprintf('setup%sConfig', ucfirst($answer));

        $this->$configMethod();
    }

    /**
     * Setup the config for a Jira system.
     */
    private function setupJiraConfig()
    {
        var_dump('piet');
    }

    /**
     * Setup the config for a Github system.
     */
    private function setupGithubConfig()
    {
        var_dump('henk');
    }
}
