<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Feature\Resolver;


use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IInitializationModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IInitializationResolver;
use AlecRabbit\Spinner\Core\Feature\Resolver\InitializationResolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class InitializationResolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $resolver = $this->getTesteeInstance();

        self::assertInstanceOf(InitializationResolver::class, $resolver);
    }

    private function getTesteeInstance(
        ?IDriverModeDetector $driverModeDetector = null,
        ?IInitializationModeDetector $initializationModeDetector = null,
    ): IInitializationResolver {
        return new InitializationResolver(
            driverModeDetector: $driverModeDetector ?? $this->getDriverModeDetectorMock(),
            initializationModeDetector: $initializationModeDetector ?? $this->getInitializationModeDetectorMock(),
        );
    }

    private function getDriverModeDetectorMock(): MockObject&IDriverModeDetector
    {
        return $this->createMock(IDriverModeDetector::class);
    }

    private function getInitializationModeDetectorMock(): MockObject&IInitializationModeDetector
    {
        return $this->createMock(IInitializationModeDetector::class);
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

        $initializationModeDetector = $this->getInitializationModeDetectorMock();
        $initializationModeDetector
            ->expects(self::never())
            ->method('isEnabled');

        $resolver = $this->getTesteeInstance(
            driverModeDetector: $driverModeDetector,
            initializationModeDetector: $initializationModeDetector,
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

        $initializationModeDetector = $this->getInitializationModeDetectorMock();
        $initializationModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $resolver = $this->getTesteeInstance(
            driverModeDetector: $driverModeDetector,
            initializationModeDetector: $initializationModeDetector,
        );

        self::assertTrue($resolver->isEnabled());
    }
}
