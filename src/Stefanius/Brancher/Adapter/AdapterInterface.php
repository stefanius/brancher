<?php

namespace Stefanius\Brancher\Adapter;

interface AdapterInterface
{
    public function getIssueTitle();

    public function getIssueType();

    public function getIssueNumber();

    public function getAssignee();
}
