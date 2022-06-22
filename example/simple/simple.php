<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Kernel\Factory\WSpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = WSpinnerFactory::create();

echo sprintf('Spinner starts now...',) . PHP_EOL;
