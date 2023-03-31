<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\AutoInstantiator;
use AlecRabbit\Spinner\Core\ContainerFactory;

$container = ContainerFactory::createContainer();

AutoInstantiator::registerContainer($container);
