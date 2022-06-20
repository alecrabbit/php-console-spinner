<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Kernel\StyleCollection;

require_once __DIR__ . '/../bootstrap.php';

$spinner = SpinnerFactory::create();

echo sprintf('Spinner starts now...',) . PHP_EOL;
