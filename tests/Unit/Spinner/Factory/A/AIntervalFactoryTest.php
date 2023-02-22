<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Factory\A;

use AlecRabbit\Spinner\Factory\A\AIntervalFactory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AIntervalFactoryTest extends TestCase
{
    /** @test */
    public function canCreateDefaultInterval(): void
    {
        $defaults = DefaultsFactory::create();

        $this->assertEquals(
            $defaults->getIntervalMilliseconds(),
            AIntervalFactory::createDefault()->toMilliseconds()
        );
    }
}