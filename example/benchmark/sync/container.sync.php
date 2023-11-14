<?php

declare(strict_types=1);

require_once __DIR__ . '/../container.php';

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Facade;

$registry = DefinitionRegistry::getInstance();

$registry->bind(
    IWritableStream::class,
    new class implements IWritableStream {
        public function write(Traversable $data): void
        {
            // unwrap $data
            iterator_to_array($data);
        }
    }
);
$registry->bind(
    IDeltaTimer::class,
    new class implements IDeltaTimer {
        public function getDelta(): float
        {
            // simulate unequal time intervals
            return (float)random_int(1000, 500000);
        }
    }
);

$container = (new ContainerFactory($registry))->create();

Facade::useContainer($container);

return $container;
