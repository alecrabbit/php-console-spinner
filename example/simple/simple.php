<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = SpinnerFactory::create();

echo sprintf('Spinner starts now...',) . PHP_EOL;
