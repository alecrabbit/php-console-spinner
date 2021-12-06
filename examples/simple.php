<?php declare(strict_types=1);

use AlecRabbit\Spinner\Spinner;
use AlecRabbit\Spinner\SpinnerConfig;

require_once __DIR__ . '/../vendor/autoload.php';


dump('New begining :)');

$config = new SpinnerConfig();

$s = new Spinner($config);

