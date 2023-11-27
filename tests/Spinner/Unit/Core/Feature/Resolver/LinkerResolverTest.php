<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Feature\Resolver;


use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILinkerModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\ILinkerResolver;
use AlecRabbit\Spinner\Core\Feature\Resolver\LinkerResolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LinkerResolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $resolver = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerResolver::class, $resolver);
    }

    private function getTesteeInstance(
        ?ILinkerModeDetector $linkerModeDetector = null,
        ?IDriverModeDetector $driverModeDetector = null,
    ): ILinkerResolver {
        return new LinkerResolver(
            linkerModeDetector: $linkerModeDetector ?? $this->getLinkerModeDetectorMock(),
            driverModeDetector: $driverModeDetector ?? $this->getDriverModeDetectorMock(),
        );
    }

    private function getLinkerModeDetectorMock(): MockObject&ILinkerModeDetector
    {
        return $this->createMock(ILinkerModeDetector::class);
    }

    private function getDriverModeDetectorMock(): MockObject&IDriverModeDetector
    {
        return $this->createMock(IDriverModeDetector::class);
    }

    #[Test]
    public function canResolveWhenDisabled(): void
    {
        $driverModeDetector = $this->getDriverModeDetectorMock();
        $driverModeDetector
            ->expects(self::never())
            ->method('isEnabled')
        ;

        $linkerModeDetector = $this->getLinkerModeDetectorMock();
        $linkerModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(false)
        ;

        $resolver = $this->getTesteeInstance(
            linkerModeDetector: $linkerModeDetector,
            driverModeDetector: $driverModeDetector,
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

        $initializationModeDetector = $this->getLinkerModeDetectorMock();
        $initializationModeDetector
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $resolver = $this->getTesteeInstance(
            driverModeDetector: $driverModeDetector,
            linkerModeDetector: $initializationModeDetector,
        );

        self::assertTrue($resolver->isEnabled());
    }
}
