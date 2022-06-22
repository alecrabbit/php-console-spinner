<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit;

use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use PHPUnit\Framework\TestCase;

final class ConfigBuilderTest extends TestCase
{
    /** @test */
    public function createInstance(): void
    {
        $config = (new ConfigBuilder())->build();
        self::assertTrue($config->isAsynchronous());
    }
}
