<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.async.php';

echo '--' . PHP_EOL;

$spinner = Facade::createSpinner();
$driver = Facade::getDriver();
$loop = Facade::getLoop();

dump($loop);
dump($spinner);
dump($driver);
foreach (\AlecRabbit\Tests\Helper\PickLock::getValue($driver, 'spinners') as $s) {
    dump($s);
}

$loop->repeat(
    1,
    static function () {
        echo MemoryUsage::report() . PHP_EOL;
    }
);
$loop->run();
