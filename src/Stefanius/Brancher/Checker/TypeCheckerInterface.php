<?php

namespace Stefanius\Brancher\Checker;

interface TypeCheckerInterface
{
    /**
     * @return boolean
     */
    public function breakEarly();

    /**
     * @param $param
     *
     * @return boolean
     */
    public function isOk($param = null);

    /**
     * @return string
     */
    public function getErrorMessage();
}
