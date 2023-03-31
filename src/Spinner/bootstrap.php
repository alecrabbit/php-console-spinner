<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\AutoInstantiator;
use AlecRabbit\Spinner\Core\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;

$container = ContainerFactory::createContainer();

AutoInstantiator::registerContainer($container);

$ff = $container->get(IFrameFactory::class);
dump($ff);
