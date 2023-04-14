<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverAttacher;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class DriverAttacherTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverAttacher = $this->getTesteeInstance();

        self::assertInstanceOf(DriverAttacher::class, $driverAttacher);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): IDriverAttacher {
        return
            new DriverAttacher(
                loop: $loop ?? $this->getLoopMock(),
                optionAttacher: OptionAttacher::ENABLED,
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

        $driverAttacher = $this->getTesteeInstance($loop);

        $driverAttacher->attach($driver);
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

        $driverAttacher = $this->getTesteeInstance($loop);

        $driverAttacher->attach($driver);

        $driverAttacher->attach($driver);
    }
}
