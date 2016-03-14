<?php

namespace Stefanius\Brancher\Adapter;

use Stefanius\Brancher\Issue\Issue;

class GithubAdapter extends AbstractAdapter
{
    protected $apiUrl = 'https://api.github.com/repos/';

    /**
     * @param string $issueCode
     *
     * @return Issue
     */
    public function find($issueCode)
    {
        $concatinated = $this->apiUrl . $this->config['owner'] . '/' . $this->config['repo'] . '/issues/' . $issueCode;

        $this->response = $this->guzzle
            ->get($concatinated, ['auth' => [$this->config['username'], $this->config['token']]])
            ->send()
        ;

        $data = $this->response->json();

        $issue = new Issue();
        $issue->setId($data['id']);
        $issue->setCode($issueCode);
        $issue->setAssignee($data['assignee']);
        $issue->setTitle($data['title']);
        $issue->setDescription($data['body']);

        return $issue;
    }
}
