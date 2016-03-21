<?php

namespace Stefanius\Brancher\Adapter;

use Stefanius\Brancher\Issue\Issue;

class GithubAdapter extends AbstractAdapter
{
    protected $apiUrl = 'https://api.github.com/repos/';

    protected $issueCode;

    /**
     * @param string $issueCode
     *
     * @return Issue
     */
    public function prepare($issueCode)
    {
        $concatinated = $this->apiUrl . $this->config['owner'] . '/' . $this->config['repo'] . '/issues/' . $issueCode;

        $this->response = $this->guzzle
            ->get($concatinated, ['auth' => [$this->config['username'], $this->config['token']]])
            ->send()
        ;

        $this->issueCode = $issueCode;

        return $this->response->json();
    }

    protected function getIdAttribute(array $data)
    {
        return $data['id'];
    }

    protected function getCodeAttribute(array $data)
    {
        return $this->issueCode;
    }

    protected function getAssigneeAttribute(array $data)
    {
        return $data['assignee'];
    }

    protected function getTitleAttribute(array $data)
    {
        return $data['title'];
    }

    protected function getDescriptionAttribute(array $data)
    {
        return $data['body'];
    }
}
