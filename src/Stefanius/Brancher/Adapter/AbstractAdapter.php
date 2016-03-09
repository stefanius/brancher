<?php

namespace Stefanius\Brancher\Adapter;

use Guzzle\Http\Client;

abstract class AbstractAdapter implements AdapterInterface
{
    protected $guzzle;

    protected $config;

    protected $response;

    /**
     * AbstractAdapter constructor.
     *
     * @param $guzzle
     * @param $config
     */
    public function __construct(Client $guzzle, array $config)
    {
        $this->guzzle = $guzzle;
        $this->config = $config;
    }

    abstract public function find($issue);
}