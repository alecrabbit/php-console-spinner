<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Mixin;

use AlecRabbit\Spinner\Container\AutoInstantiator;

trait AutoInstantiableTrait
{
    final public static function getInstance(): object
    {
        return AutoInstantiator::createInstance(static::class);
    }
}
