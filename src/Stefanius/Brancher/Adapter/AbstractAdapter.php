<?php

namespace Stefanius\Brancher\Adapter;

use Guzzle\Http\Client;
use Stefanius\Brancher\Issue\Issue;

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

    /**
     * @param string $issueCode
     *
     * @return Issue
     */
    public function find($issueCode)
    {
        $data = $this->prepare($issueCode);

        return $this->createIssue($data);
    }

    protected function createIssue(array $data)
    {
        $issue = new Issue();

        $issue->setId($this->getIdAttribute($data));
        $issue->setCode($this->getCodeAttribute($data));
        $issue->setAssignee($this->getAssigneeAttribute($data));
        $issue->setTitle($this->getTitleAttribute($data));
        $issue->setDescription($this->getDescriptionAttribute($data));

        return $issue;
    }

    abstract protected function prepare($issue);

    abstract protected function getIdAttribute(array $data);

    abstract protected function getCodeAttribute(array $data);

    abstract protected function getAssigneeAttribute(array $data);

    abstract protected function getTitleAttribute(array $data);

    abstract protected function getDescriptionAttribute(array $data);
}
