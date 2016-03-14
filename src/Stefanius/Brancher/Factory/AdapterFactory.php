<?php

namespace Stefanius\Brancher\Factory;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\AdapterInterface;
use Stefanius\Brancher\Adapter\JiraAdapter;

class AdapterFactory
{
    /**
     * @param Client $client
     * @param array  $config
     *
     * @return AdapterInterface
     */
    static public function Create(Client $client, array $config)
    {
        if (array_key_exists('jira', $config)) {
            return new JiraAdapter($client, $config['jira']);
        } elseif (array_key_exists('github', $config)) {
            return new JiraAdapter($client, $config['github']);
        }
    }
}