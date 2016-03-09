<?php

namespace Stefanius\Brancher\Adapter;

use Stefanius\Brancher\Issue\Issue;

class JiraAdapter extends AbstractAdapter
{
    protected $apiUrl = 'rest/api/latest/issue/';

    public function find($issue)
    {
        $concatinated = $this->config['host'] . $this->apiUrl . $issue;

        $this->response = $this->guzzle
            ->get($concatinated)
            ->addHeader('Authorization', 'Basic ' . $this->config['auth'])
            ->send()
        ;

        $data = $this->response->json();

        $issue = new Issue();
        $issue->setId($data['id']);
        $issue->setCode($data['id']);
        $issue->setAssignee($data['key']);
        $issue->setTitle($data['fields']['summary']);
        $issue->setDescription($data['fields']['description']);

        return $issue;
    }

    public function getIssueTitle()
    {
        // TODO: Implement getIssueTitle() method.
    }

    public function getIssueType()
    {
        // TODO: Implement getIssueType() method.
    }

    public function getIssueNumber()
    {
        // TODO: Implement getIssueNumber() method.
    }

    public function getAssignee()
    {
        // TODO: Implement getAssignee() method.
    }

}