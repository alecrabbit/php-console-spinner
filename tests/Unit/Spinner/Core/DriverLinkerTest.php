<?php

declare(strict_types=1);

// 03.04.23

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverLinkerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverLinker = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinker::class, $driverLinker);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): IDriverLinker {
        return new DriverLinker(
            loop: $loop ?? $this->getLoopMock(),
            optionLinker: OptionLinker::ENABLED,
        );
    }

    #[Test]
    public function canAttach(): void
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

        $driverLinker = $this->getTesteeInstance($loop);

        $driverLinker->link($driver);
    }

    #[Test]
    public function canReattach(): void
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

        $driverLinker = $this->getTesteeInstance($loop);

        $driverLinker->link($driver);

        $driverLinker->link($driver);
    }
}
