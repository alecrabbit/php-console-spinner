<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

abstract class PcntlAwareTestCase extends TestCase
{
    protected function isPcntlExtensionAvailable(): bool
    {
        return function_exists('pcntl_signal');
    }
}
