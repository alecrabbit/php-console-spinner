<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Mixin;

trait NonInstantiable
{
    // @codeCoverageIgnoreStart
    /** @psalm-suppress UnusedConstructor */
    final private function __construct()
    {
        // no instances, can NOT be overridden
    }
    // @codeCoverageIgnoreEnd
}
