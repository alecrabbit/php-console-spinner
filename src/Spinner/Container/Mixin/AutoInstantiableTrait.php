<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Mixin;

use AlecRabbit\Spinner\Container\Instantiator;

trait AutoInstantiableTrait
{
    final public static function getInstance(): object
    {
        return Instantiator::createInstance(static::class);
    }
}
