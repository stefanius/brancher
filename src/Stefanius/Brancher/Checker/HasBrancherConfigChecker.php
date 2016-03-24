<?php

namespace Stefanius\Brancher\Checker;

class HasBrancherConfigChecker implements TypeCheckerInterface
{
    /**
     * return bool
     */
    public function breakEarly()
    {
        return false;
    }

    /**
     * @param null $param
     *
     * @return bool
     */
    public function isOk($param = null)
    {
        if (is_null($param) || empty($param)) {
            return false;
        }

        if (!is_dir($param)) {
            return false;
        }

        $dirs = scandir($param);

        return in_array('.brancher', $dirs);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return "There is no '.brancher' config file. Run the 'brancher:setup' command.";
    }
}
