<?php

error_reporting(E_ALL);
require_once __DIR__ . './vendor/autoload.php';

use Cda0521Framework\Application\TestApplication;

$application = new TestApplication();
$application->setup();
$application->run();
