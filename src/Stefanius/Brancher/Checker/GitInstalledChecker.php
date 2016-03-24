<?php

namespace Stefanius\Brancher\Checker;

class GitInstalledChecker implements TypeCheckerInterface
{
    /**
     * return bool
     */
    public function breakEarly()
    {
        return true;
    }

    /**
     * @param null $param
     *
     * @return bool
     */
    public function isOk($param = null)
    {
        exec("which git", $output);

        $output = trim(implode("", $output));

        return !empty($output);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return 'It seems that GIT is not installed. Make sure you installed GIT.!';
    }
}
