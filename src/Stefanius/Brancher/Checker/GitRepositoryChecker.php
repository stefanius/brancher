<?php

namespace Stefanius\Brancher\Checker;

class GitRepositoryChecker implements TypeCheckerInterface
{
    protected $errorMessage;

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
        if (is_null($param) || empty($param)) {
            $this->errorMessage = "There is no known working directory. Its impossible to detect if it is a git repo.";

            return false;
        }

        if (!is_dir($param)) {
            $this->errorMessage = sprintf("'%s' is not a directory. So it can't be a git repo.");

            return false;
        }

        $this->errorMessage = sprintf("'%s' is not a git repo. It is not possible to perform git tasks on it.", $param);

        $dirs = scandir($param);

        return in_array('.git', $dirs);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
