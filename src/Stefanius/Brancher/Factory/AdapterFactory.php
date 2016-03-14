<?php

namespace Stefanius\Brancher\Factory;

use Guzzle\Http\Client;
use Stefanius\Brancher\Adapter\AdapterInterface;
use Stefanius\Brancher\Adapter\GithubAdapter;
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
        $primaryConnection = $config['settings']['primary_connection'];

        if (array_key_exists('jira', $config) && $primaryConnection === 'jira') {
            return new JiraAdapter($client, $config['jira']);
        } elseif (array_key_exists('github', $config) && $primaryConnection === 'github') {
            return new GithubAdapter($client, $config['github']);
        }
    }
}