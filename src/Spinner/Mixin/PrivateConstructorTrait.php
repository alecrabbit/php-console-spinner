<?php

declare(strict_types=1);
// 02.03.23
namespace AlecRabbit\Spinner\Mixin;

trait PrivateConstructorTrait
{
    // @codeCoverageIgnoreStart
    private function __construct()
    {
        // no instances, can be overridden
    }
    // @codeCoverageIgnoreEnd
}