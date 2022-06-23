<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit;

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
