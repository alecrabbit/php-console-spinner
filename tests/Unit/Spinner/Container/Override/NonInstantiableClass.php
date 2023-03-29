<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override;

use RuntimeException;

final class NonInstantiableClass
{
    public function __construct()
    {
        throw new RuntimeException('This class is not instantiable');
    }

}
