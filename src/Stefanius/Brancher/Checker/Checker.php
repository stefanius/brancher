<?php

namespace Stefanius\Brancher\Checker;

class Checker
{
    protected $workingDir;

    protected $checkers = [];

    /**
     * PathChecker constructor.
     *
     * @param $workingDir
     */
    public function __construct($workingDir)
    {
        $this->workingDir = $workingDir;

        $this->checkers = [
            new GitInstalledChecker(),
            new GitRepositoryChecker(),
            new HasBrancherConfigChecker(),
        ];
    }

    /**
     * @param bool $breakEarly
     * @return bool
     * 
     * @throws \Exception
     */
    public function isOk($breakEarly = true)
    {
        foreach ($this->checkers as $checker) {
            if (!$checker instanceof TypeCheckerInterface) {
                throw new \Exception('Checker has a unknown type.');
            }

            if (!$checker->isOk($this->workingDir) && (!$checker->breakEarly() === $breakEarly || $checker->breakEarly())) {
                throw new \Exception($checker->getErrorMessage());
            }
        }

        return true;
    }
}
