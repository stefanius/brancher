<?php

namespace Stefanius\Brancher\Command;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\AdapterInterface;
use Stefanius\Brancher\Factory\AdapterFactory;
use Stefanius\Slugifier\Manipulators\SlugManipulator;
use Symfony\Component\Console\Command\Command;
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
}
