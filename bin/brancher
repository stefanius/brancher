#!/usr/bin/env php
<?php
// application.php

require 'vendor/autoload.php';

use Stefanius\Brancher\Command\TestCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new TestCommand());
$application->add(new \Stefanius\Brancher\Command\BrancherCommand());
$application->run();