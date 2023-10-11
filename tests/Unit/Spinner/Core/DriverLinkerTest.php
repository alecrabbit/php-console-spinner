<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverLinkerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverLinker = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinker::class, $driverLinker);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): IDriverLinker {
        return new DriverLinker(
            loop: $loop ?? $this->getLoopMock(),
        );
    }

    #[Test]
    public function canLink(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('repeat')
            ->willReturn(1)
        ;

        $loop
            ->expects(self::never())
            ->method('cancel')
        ;

        $intervalMock = $this->getIntervalMock();
        $intervalMock
            ->expects(self::once())
            ->method('toSeconds')
            ->willReturn(1.0)
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($intervalMock)
        ;

        $driverLinker = $this->getTesteeInstance(
            loop: $loop,
        );

        $driverLinker->link($driver);
    }

    #[Test]
    public function canBeUpdated(): void
    {
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::exactly(2))
            ->method('getInterval')
        ;
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('cancel')
        ;
        $loop
            ->expects(self::exactly(2))
            ->method('repeat')
            ->willReturn(1, 2)
        ;
        $driverLinker = $this->getTesteeInstance(
            loop: $loop,
        );

        $driverLinker->link($driver);

        $driverLinker->update($driver);
    }

    #[Test]
    public function canRelink(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::exactly(2))
            ->method('repeat')
            ->willReturn(1)
        ;

        $loop
            ->expects(self::once())
            ->method('cancel')
        ;

        $intervalMock = $this->getIntervalMock();
        $intervalMock
            ->expects(self::exactly(2))
            ->method('toSeconds')
            ->willReturn(1.0)
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($intervalMock)
        ;

        $driverLinker = $this->getTesteeInstance(
            loop: $loop,
        );

        $driverLinker->link($driver);

        $driverLinker->link($driver);
    }

    #[Test]
    public function throwsIfLinkOfOtherInstanceOfDriverAttempted(): void
    {
        $e = new LogicException(
            'Other instance of driver is already linked.'
        );

        $test = function (): void {
            $driverLinker = $this->getTesteeInstance();

            $driver = $this->getDriverMock();

            $driverLinker->link($driver);
            $driverLinker->link($this->getDriverMock());
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $e,
        );
    }
}
