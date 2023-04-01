<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\Instantiator;
use AlecRabbit\Spinner\Core\ContainerFactory;

$container = ContainerFactory::createContainer();

Instantiator::registerContainer($container);
