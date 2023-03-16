<?php

declare(strict_types=1);
// 02.03.23

namespace AlecRabbit\Spinner\Mixin;

trait NoInstanceTrait
{
    // @codeCoverageIgnoreStart
    final private function __construct()
    {
        // no instances, can NOT be overridden
    }
    // @codeCoverageIgnoreEnd
}
