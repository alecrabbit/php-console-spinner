<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit;

use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Tests\Spinner\TestCase;

final class ConfigBuilderTest extends TestCase
{
    /** @test */
    public function defaultInstance(): void
    {
        $config = self::getDefaultConfig();
        self::assertTrue($config->isAsynchronous());
    }
}
