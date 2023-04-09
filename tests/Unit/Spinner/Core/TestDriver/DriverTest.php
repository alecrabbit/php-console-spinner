<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\TestDriver;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(Driver::class, $driver);

        self::assertCount(0, self::getValue('spinners', $driver));
        self::assertFalse(self::getValue('initialized', $driver));
    }

    public function getTesteeInstance(
        ?IBufferedOutput $output = null,
        ?ICursor $cursor = null,
        ?ITimer $timer = null,
        ?string $interruptMessage = null,
        ?string $finalMessage = null,
        ?\Closure $intervalCb = null,
    ): IDriver {
        return
            new Driver(
                output: $output ?? $this->getBufferedOutputMock(),
                cursor: $cursor ?? $this->getCursorMock(),
                timer: $timer ?? $this->getTimerMock(),
                interruptMessage: $interruptMessage ?? '--interrupted--',
                finalMessage: $finalMessage ?? '--finalized--',
                intervalCb: $intervalCb ?? static fn() => new Interval(),
            );
    }

    #[Test]
    public function canRender(): void
    {
        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('update')
            ->with(self::equalTo(null))
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('bufferedWrite')
        ;
        $output
            ->expects(self::once())
            ->method('flush')
        ;

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('erase')
        ;
        $cursor
            ->expects(self::once())
            ->method('moveLeft')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor
            );

        $driver->add($spinner);

        $driver->render();
    }

    #[Test]
    public function canRenderUsingTimer(): void
    {
        $delta = 0.1;
        $timer = $this->getTimerMock();
        $timer
            ->expects(self::once())
            ->method('getDelta')
            ->willReturn($delta);

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('update')
            ->with(self::equalTo($delta))
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('bufferedWrite')
        ;

        $output
            ->expects(self::once())
            ->method('flush')
        ;

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('erase')
        ;
        $cursor
            ->expects(self::once())
            ->method('moveLeft')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
                timer: $timer
            );

        $driver->add($spinner);

        $driver->render();
    }

    #[Test]
    public function hidesCursorOnInitializeAndOnInterruptShowsCursorAndWritesToOutput(): void
    {
        $interruptMessage = 'interruptMessage';

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('hide')
        ;
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canBeInitialized(): void
    {
        $driver = $this->getTesteeInstance();

        $driver->initialize();

        self::assertTrue(self::getValue('initialized', $driver));
    }

    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::never())
            ->method('erase')
        ;

        $driver = $this->getTesteeInstance(cursor: $cursor);

        $intervalOne = new Interval(1200);
        $intervalTwo = new Interval(135);

        $spinnerOne = $this->getSpinnerStub();
        $spinnerOne
            ->method('getInterval')
            ->willReturn($intervalOne)
        ;

        $driver->add($spinnerOne);
        self::assertCount(1, self::getValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $spinnerTwo = $this->getSpinnerStub();
        $spinnerTwo
            ->method('getInterval')
            ->willReturn($intervalTwo)
        ;

        $driver->add($spinnerTwo);

        self::assertCount(2, self::getValue('spinners', $driver));
        self::assertSame($intervalTwo, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertCount(1, self::getValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertCount(1, self::getValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $driver->remove($spinnerOne);

        self::assertCount(0, self::getValue('spinners', $driver));
        self::assertEquals(new Interval(), $driver->getInterval());
    }


    #[Test]
    public function canBeFinalized(): void
    {
        $finalMessage = 'finalMessage';

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function throwsIfInvalidIntervalCallbackProvided(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage =
            'Interval callback must return an instance of'
            . ' "AlecRabbit\Spinner\Contract\IInterval", "null" received.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $_ =
            $this->getTesteeInstance(
                intervalCb: fn() => null
            );

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
