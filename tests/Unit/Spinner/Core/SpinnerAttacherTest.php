<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\SpinnerAttacher;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;


final class SpinnerAttacherTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerAttacher = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerAttacher::class, $spinnerAttacher);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?WeakMap $timerMap = null,
    ): ISpinnerAttacher {
        return
            new SpinnerAttacher(
                loop: $loop ?? $this->getLoopMock(),
                timerMap: $timerMap ?? new WeakMap(),
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

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($intervalMock)
        ;

        $timerMap = new WeakMap();

        $spinnerAttacher = $this->getTesteeInstance($loop, $timerMap);

        $spinnerAttacher->attach($spinner);

        self::assertTrue($timerMap->offsetExists($spinner));
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

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::exactly(2))
            ->method('getInterval')
            ->willReturn($intervalMock)
        ;

        $timerMap = new WeakMap();

        $spinnerAttacher = $this->getTesteeInstance($loop, $timerMap);

        $spinnerAttacher->attach($spinner);

        self::assertTrue($timerMap->offsetExists($spinner));

        $spinnerAttacher->attach($spinner);

        self::assertTrue($timerMap->offsetExists($spinner));
    }
}
