<?php

namespace Stefanius\Brancher\Command;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\AdapterInterface;
use Stefanius\Brancher\Factory\AdapterFactory;
use Stefanius\Brancher\Issue\Issue;
use Stefanius\Slugifier\Manipulators\SlugManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

abstract class BaseCommand extends Command
{
    /**
     * @return Client
     */
    protected function buildGuzzleClient()
    {
        return new Client();
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return Yaml::parse(file_get_contents('/Users/sgrootveld/PhpstormProjects/brancher/.brancher'));
    }

    /**
     * @return AdapterInterface
     */
    protected function buildAdapter()
    {
        return AdapterFactory::Create($this->buildGuzzleClient(), $this->getConfig());
    }

    /**
     * @return SlugManipulator
     */
    protected function getSlugifier()
    {
        return new SlugManipulator();
    }

    /**
     * @param Issue $issue
     *
     * @return string
     */
    protected function getBranchSlug(Issue $issue)
    {
        return $this->getSlugifier()->manipulate($issue->getCode() . '-' . $issue->getTitle());
    }
    /**
     * @param Issue $issue
     *
     * @return Process
     */
    protected function getCreateBranchProcess(Issue $issue)
    {
        $slug = $this->getBranchSlug($issue);

        return new Process('git checkout -b ' . $slug);
    }

    /**
     * @param Issue $issue
     *
     * @return Process
     */
    protected function getBranchExistsProcess(Issue $issue)
    {
        $slug = $this->getBranchSlug($issue);

        return new Process('git rev-parse --verify ' . $slug);
    }

    /**
     * @param Issue $issue
     *
     * @return bool
     */
    protected function isBranchExists(Issue $issue)
    {
        $process = $this->getBranchExistsProcess($issue);
        $process->run();

        return strlen(trim($process->getErrorOutput())) === 0;
    }

    /**
     * @param Process $process
     *
     * @throws \Exception
     */
    protected function runProcess(Process $process)
    {
        $process->run();

        var_dump($process->getExitCode());
        if (strlen(trim($process->getErrorOutput())) > 0) {
            //throw new \Exception($process->getErrorOutput());
        }
    }
}
