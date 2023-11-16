<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\RevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IRevolverConfigBuilder
    {
        return
            new RevolverConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withTolerance($this->getToleranceMock())
            ->build()
        ;

        self::assertInstanceOf(RevolverConfig::class, $config);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    #[Test]
    public function throwsIfToleranceIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Tolerance is not set.');

        $configBuilder = $this->getTesteeInstance();

        $configBuilder->build();
    }
}
