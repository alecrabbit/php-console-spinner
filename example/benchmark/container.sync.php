<?php

declare(strict_types=1);

require_once __DIR__ . '/container.php';

use AlecRabbit\Benchmark\Factory\RandomDeltaTimerFactory;
use AlecRabbit\Benchmark\Factory\WritableStreamFactory;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IWritableStreamFactory;

$registry = DefinitionRegistry::getInstance();

$registry->bind(
    new ServiceDefinition(
        IWritableStreamFactory::class,
        WritableStreamFactory::class
    ),
    new ServiceDefinition(
        IDeltaTimerFactory::class,
        RandomDeltaTimerFactory::class,
    )
);
