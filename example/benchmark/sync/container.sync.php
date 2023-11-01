<?php

declare(strict_types=1);

require_once __DIR__ . '/../container.php';

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Facade;

$registry = DefinitionRegistry::getInstance();

$registry->bind(
    IResourceStream::class,
    new class implements IResourceStream {
        public function write(Traversable $data): void
        {
            // unwrap $data
            iterator_to_array($data);
        }
    }
);
$registry->bind(
    ITimer::class,
    new class implements ITimer {
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
