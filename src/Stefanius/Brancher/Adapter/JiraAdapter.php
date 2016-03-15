<?php

namespace Stefanius\Brancher\Adapter;

use Stefanius\Brancher\Issue\Issue;

class JiraAdapter extends AbstractAdapter
{
    protected $apiUrl = 'rest/api/latest/issue/';

    /**
     * @param string $issueCode
     *
     * @return Issue
     */
    public function find($issueCode)
    {
        $concatinated = $this->config['host'] . $this->apiUrl . $issueCode;

        $this->response = $this->guzzle
            ->get($concatinated)
            ->addHeader('Authorization', 'Basic ' . $this->config['auth'])
            ->send()
        ;

        $data = $this->response->json();

        $issue = new Issue();
        $issue->setId($data['id']);
        $issue->setCode($data['key']);
        $issue->setAssignee($data['key']);
        $issue->setTitle($data['fields']['summary']);
        $issue->setDescription($data['fields']['description']);

        return $issue;
    }
}