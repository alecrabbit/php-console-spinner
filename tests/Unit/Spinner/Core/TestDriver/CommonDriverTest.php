<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\TestDriver;

use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class CommonDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canBeCreated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(Driver::class, $driver);

        self::assertCount(0, self::getValue('spinners', $driver));
        self::assertFalse(self::getValue('initialized', $driver));
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
