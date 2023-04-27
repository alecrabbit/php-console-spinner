<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Container\Override;

use RuntimeException;

final class NonInstantiableClass
{
    public function __construct()
    {
        throw new RuntimeException('This class is not instantiable');
    }
}
