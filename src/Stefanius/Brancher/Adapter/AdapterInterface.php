<?php

namespace Stefanius\Brancher\Adapter;

use Stefanius\Brancher\Issue\Issue;

interface AdapterInterface
{
    /**
     * @param string $issueCode
     *
     * @return Issue
     */
    public function find($issueCode);
}
