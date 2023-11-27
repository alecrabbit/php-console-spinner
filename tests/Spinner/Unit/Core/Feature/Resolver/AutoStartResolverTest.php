<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Feature\Resolver;


use AlecRabbit\Spinner\Core\Config\Contract\Detector\IAutoStartModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\AutoStartResolver;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AutoStartResolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $resolver = $this->getTesteeInstance();

        self::assertInstanceOf(AutoStartResolver::class, $resolver);
    }

    private function getTesteeInstance(
        ?IDriverModeDetector $driverModeDetector = null,
        ?IAutoStartModeDetector $autoStartModeDetector = null,
    ): IAutoStartResolver {
        return new AutoStartResolver(
            driverModeDetector: $driverModeDetector ?? $this->getDriverModeDetectorMock(),
            autoStartModeDetector: $autoStartModeDetector ?? $this->getAutoStartModeDetectorMock(),
        );
    }

    private function getDriverModeDetectorMock(): MockObject&IDriverModeDetector
    {
        return $this->createMock(IDriverModeDetector::class);
    }

    private function getAutoStartModeDetectorMock(): MockObject&IAutoStartModeDetector
    {
        return $this->createMock(IAutoStartModeDetector::class);
    }

    #[Test]
    public function canResolveWhenDisabled(): void
    {
        $driverModeDetector = $this->getDriverModeDetectorMock();
        $driverModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(false)
        ;

        $initializationModeDetector = $this->getAutoStartModeDetectorMock();
        $initializationModeDetector
            ->expects(self::never())
            ->method('isEnabled')
        ;

        $resolver = $this->getTesteeInstance(
            driverModeDetector: $driverModeDetector,
            autoStartModeDetector: $initializationModeDetector,
        );

        self::assertFalse($resolver->isEnabled());
    }

    #[Test]
    public function canResolveWhenEnabled(): void
    {
        $driverModeDetector = $this->getDriverModeDetectorMock();
        $driverModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $initializationModeDetector = $this->getAutoStartModeDetectorMock();
        $initializationModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $resolver = $this->getTesteeInstance(
            driverModeDetector: $driverModeDetector,
            autoStartModeDetector: $initializationModeDetector,
        );

        self::assertTrue($resolver->isEnabled());
    }
}
