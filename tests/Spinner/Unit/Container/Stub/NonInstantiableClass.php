<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Stub;

use RuntimeException;

final class NonInstantiableClass
{
    public function __construct()
    {
        throw new RuntimeException('This class is not instantiable');
    }
}
