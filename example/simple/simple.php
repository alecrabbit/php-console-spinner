<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\StyleCollection;

require_once __DIR__ . '/../bootstrap.php';

$sc = StyleCollection::create(...StylePattern::rainbow())    ;

dump($sc);

$spinner = SpinnerFactory::create();

echo sprintf('Spinner starts now...',) . PHP_EOL;
