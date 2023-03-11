<?php

declare(strict_types=1);
// 11.03.23
namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

use function trigger_error;

use const E_USER_DEPRECATED;

final class Deprecation
{
    use NoInstanceTrait;

    public static function method(string $method): void
    {
        $c = new ClassImpl();
        trigger_error(
            sprintf('Method "%s" is deprecated', $method),
            E_USER_DEPRECATED
        );
    }
}