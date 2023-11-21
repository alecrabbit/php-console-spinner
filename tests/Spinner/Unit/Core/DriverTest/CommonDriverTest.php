<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\DriverTest;

use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Interval;
use PHPUnit\Framework\Attributes\Test;

final class CommonDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(Driver::class, $driver);

        self::assertNull(self::getPropertyValue('spinner', $driver));
    }

    #[Test]
    public function hidesCursorOnInitializeAndOnInterruptShowsCursorAndWritesToOutput(): void
    {
        $interruptMessage = 'interruptMessage';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    // // FIXME (2023-11-21 17:2) [Alec Rabbit]: move to functional tests
//    #[Test]
//    public function canAddAndRemoveSpinner(): void
//    {
//        $initialInterval = new Interval(2000);
//
//        $intervalComparator = $this->getIntervalComparatorMock();
//
//        $driver = $this->getTesteeInstance(
//            initialInterval: $initialInterval,
//            intervalComparator: $intervalComparator,
//        );
//
//        $intervalOne = new Interval(1200);
//        $intervalTwo = new Interval(135);
//
//        $spinnerOne = $this->getSpinnerStub();
//        $spinnerOne
//            ->method('getInterval')
//            ->willReturn($intervalOne)
//        ;
//
//        $driver->add($spinnerOne);
//        self::assertSame($spinnerOne, self::getPropertyValue('spinner', $driver));
//        self::assertSame($intervalOne, $driver->getInterval());
//
//        $spinnerTwo = $this->getSpinnerStub();
//        $spinnerTwo
//            ->method('getInterval')
//            ->willReturn($intervalTwo)
//        ;
//
//        $driver->add($spinnerTwo);
//
//        self::assertSame($spinnerTwo, self::getPropertyValue('spinner', $driver));
//        self::assertSame($intervalTwo, $driver->getInterval());
//
//        $driver->remove($spinnerTwo);
//
//        self::assertNull(self::getPropertyValue('spinner', $driver));
//        self::assertSame($initialInterval, $driver->getInterval());
//
//        $driver->remove($spinnerTwo);
//
//        self::assertNull(self::getPropertyValue('spinner', $driver));
//        self::assertSame($initialInterval, $driver->getInterval());
//
//        $driver->remove($spinnerOne);
//
//        self::assertNull(self::getPropertyValue('spinner', $driver));
//        self::assertSame($initialInterval, $driver->getInterval());
//    }

    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $initialInterval = new Interval(2000);

        $intervalComparator = $this->getIntervalComparatorMock();

        $driver = $this->getTesteeInstance(
            initialInterval: $initialInterval,
            intervalComparator: $intervalComparator,
        );

        $spinnerOne = $this->getSpinnerStub();

        $driver->add($spinnerOne);
        self::assertSame($spinnerOne, self::getPropertyValue('spinner', $driver));

        $spinnerTwo = $this->getSpinnerStub();

        $driver->add($spinnerTwo);

        self::assertSame($spinnerTwo, self::getPropertyValue('spinner', $driver));

        $driver->remove($spinnerTwo);

        self::assertNull(self::getPropertyValue('spinner', $driver));

        $driver->remove($spinnerTwo);

        self::assertNull(self::getPropertyValue('spinner', $driver));

        $driver->remove($spinnerOne);

        self::assertNull(self::getPropertyValue('spinner', $driver));
    }
}
