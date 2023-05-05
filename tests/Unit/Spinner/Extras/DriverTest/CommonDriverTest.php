<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Extras\Driver;
use PHPUnit\Framework\Attributes\Test;

final class CommonDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canBeCreated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(Driver::class, $driver);

        self::assertCount(0, self::getPropertyValue('spinners', $driver));
    }

    #[Test]
    public function hidesCursorOnInitializeAndOnInterruptShowsCursorAndWritesToOutput(): void
    {
        $interruptMessage = 'interruptMessage';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $initialInterval = new Interval(2000);

        $driver = $this->getTesteeInstance(
            initialInterval: $initialInterval
        );

        $intervalOne = new Interval(1200);
        $intervalTwo = new Interval(135);

        $spinnerOne = $this->getSpinnerStub();
        $spinnerOne
            ->method('getInterval')
            ->willReturn($intervalOne)
        ;

        $driver->add($spinnerOne);
        self::assertCount(1, self::getPropertyValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $spinnerTwo = $this->getSpinnerStub();
        $spinnerTwo
            ->method('getInterval')
            ->willReturn($intervalTwo)
        ;

        $driver->add($spinnerTwo);

        self::assertCount(2, self::getPropertyValue('spinners', $driver));
        self::assertSame($intervalTwo, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertCount(1, self::getPropertyValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertCount(1, self::getPropertyValue('spinners', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $driver->remove($spinnerOne);

        self::assertCount(0, self::getPropertyValue('spinners', $driver));
        self::assertSame($initialInterval, $driver->getInterval());
    }
//
//    #[Test]
//    public function throwsIfInvalidIntervalCallbackProvided(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage =
//            'Interval callback MUST return an instance of "'
//            . IInterval::class
//            . '", instead returns "null".';
//
//        $this->expectException($exceptionClass);
//        $this->expectExceptionMessage($exceptionMessage);
//
//        $_ =
//            $this->getTesteeInstance(
//                intervalCb: static fn() => null
//            );
//
//        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
//    }
}
