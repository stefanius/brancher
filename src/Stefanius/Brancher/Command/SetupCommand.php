<?php

namespace Stefanius\Brancher\Command;

use Stefanius\Brancher\Checker\Checker;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Dumper;

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

        $this->$configMethod($input, $output);
    }

    /**
     * @param array $config
     */
    protected function writeYamlData(array $config)
    {
        $dumper = new Dumper();

        $yamlData = $dumper->dump($config, 4);

        file_put_contents('.brancher', $yamlData);
    }

    /**
     * Setup the config for a Jira system.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function setupJiraConfig(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $answers = [];

        $questions = [
            'username' => new Question('Please enter your username: '),
            'password' => new Question('Please enter your password: '),
            'host'     => new Question('Please enter the Jira host: '),
        ];

        foreach ($questions as $key => $question) {
            $answers[$key] = $helper->ask($input, $output, $question);
        }

        $answers['auth'] = base64_encode(sprintf('%s:%s', $answers['username'], $answers['password']));

        unset($answers['username']);
        unset($answers['password']);

        $config = [
            'settings' => [
                'primary_connection'   => 'jira',
                'secondary_connection' => 'jira',
            ],
            'github' => $answers,
        ];

        $this->writeYamlData($config);
    }

    /**
     * Setup the config for a Github system.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function setupGithubConfig(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $answers = [];

        $questions = [
            'username' => new Question('Please enter your username: '),
            'owner'    => new Question('Please enter the repository owner: '),
            'repo'     => new Question('Please enter your repository: '),
            'token'    => new Question('Please enter the token: '),
        ];

        foreach ($questions as $key => $question) {
            $answers[$key] = $helper->ask($input, $output, $question);
        }

        $config = [
            'settings' => [
                'primary_connection'   => 'github',
                'secondary_connection' => 'github',
            ],
            'github' => $answers,
        ];

        $this->writeYamlData($config);
    }
}
