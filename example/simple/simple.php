<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Factory\WSpinnerFactory;
use AlecRabbit\Spinner\Kernel\WStyleCollection;

require_once __DIR__ . '/../bootstrap.php';

$spinner = WSpinnerFactory::create();

echo sprintf('Spinner starts now...',) . PHP_EOL;
