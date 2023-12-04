<?php

declare(strict_types=1);

require_once __DIR__ . '/container.php';

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;

$registry = DefinitionRegistry::getInstance();

$registry->bind(
    new ServiceDefinition(
        IWritableStream::class,
        new class() implements IWritableStream {
            public function write(Traversable $data): void
            {
                // unwrap $data
                iterator_to_array($data);
            }
        }
    ),
    new ServiceDefinition(
        IDeltaTimer::class,
        new class() implements IDeltaTimer {
            public function getDelta(): float
            {
                // simulate unequal time intervals
                return (float)random_int(1000, 500000);
            }
        }
    ),
);
