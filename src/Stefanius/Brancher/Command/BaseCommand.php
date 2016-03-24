<?php

namespace Stefanius\Brancher\Command;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\AdapterInterface;
use Stefanius\Brancher\Factory\AdapterFactory;
use Stefanius\Brancher\Issue\Issue;
use Stefanius\Brancher\Misc\Parameters;
use Stefanius\Slugifier\Manipulators\SlugManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

abstract class BaseCommand extends Command
{
    /**
     * @var Parameters
     */
    protected $parameters;

    /**
     * @param Parameters $parameters
     */
    public function setParameters(Parameters $parameters)
    {
        $this->parameters = $parameters;
    }

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
    protected function getCheckoutBranchProcess(Issue $issue)
    {
        $slug = $this->getBranchSlug($issue);

        return new Process('git checkout ' . $slug);
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

        if (strlen(trim($process->getErrorOutput())) > 0 && strpos($process->getErrorOutput(), 'fatal') !== false) {
            throw new \Exception($process->getErrorOutput());
        }
    }
}
