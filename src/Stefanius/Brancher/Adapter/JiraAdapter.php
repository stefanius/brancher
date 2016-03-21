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
    public function prepare($issueCode)
    {
        $concatinated = $this->config['host'] . $this->apiUrl . $issueCode;

        $this->response = $this->guzzle
            ->get($concatinated)
            ->addHeader('Authorization', 'Basic ' . $this->config['auth'])
            ->send()
        ;

        return $this->response->json();
    }

    protected function getIdAttribute(array $data)
    {
        return $data['id'];
    }

    protected function getCodeAttribute(array $data)
    {
        return $data['key'];
    }

    protected function getAssigneeAttribute(array $data)
    {
        return $data['key'];
    }

    protected function getTitleAttribute(array $data)
    {
        return $data['fields']['summary'];
    }

    protected function getDescriptionAttribute(array $data)
    {
        return $data['fields']['description'];
    }
}