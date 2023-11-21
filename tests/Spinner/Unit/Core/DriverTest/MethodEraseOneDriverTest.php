<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\DriverTest;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use PHPUnit\Framework\Attributes\Test;

// FIXME (2023-11-21 17:7) [Alec Rabbit]: does this test make sense?
final class MethodEraseOneDriverTest extends TestCaseForDriver
{
//    #[Test]
//    public function cursorEraseIsNotCalledIfNotInitialized(): void
//    {
//        $initialInterval = new Interval(2000);
//        $driver = $this->getTesteeInstance(
//            initialInterval: $initialInterval
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
//        self::assertNull(self::getPropertyValue('spinner', $driver));
//        self::assertSame($initialInterval, $driver->getInterval());
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
    public function cursorEraseIsNotCalledIfNotInitialized(): void
    {
        $driver = $this->getTesteeInstance();

        $spinnerOne = $this->getSpinnerStub();

        self::assertNull(self::getPropertyValue('spinner', $driver));

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

    // FIXME (2023-11-21 17:4) [Alec Rabbit]: move to functional tests
//    #[Test]
//    public function cursorEraseCalledIfInitialized(): void
//    {
//        $initialInterval = new Interval(2000);
//        $driver = $this->getTesteeInstance(
//            initialInterval: $initialInterval
//        );
//        $driver->initialize();
//
//        $intervalOne = new Interval(1200);
//        $intervalTwo = new Interval(135);
//
//        $spinnerOne = $this->getSpinnerStub();
//        $spinnerOne
//            ->method('getInterval')
//            ->willReturn($intervalOne)
//        ;
//        self::assertNull(self::getPropertyValue('spinner', $driver));
//
//        $driver->add($spinnerOne);
//
//        self::assertInstanceOf(ISpinner::class, self::getPropertyValue('spinner', $driver));
//        self::assertSame($intervalOne, $driver->getInterval());
//        self::assertSame($spinnerOne, self::getPropertyValue('spinner', $driver));
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
    public function cursorEraseCalledIfInitialized(): void
    {
        $driver = $this->getTesteeInstance();
        $driver->initialize();

        $spinnerOne = $this->getSpinnerStub();
        self::assertNull(self::getPropertyValue('spinner', $driver));

        $driver->add($spinnerOne);

        self::assertInstanceOf(ISpinner::class, self::getPropertyValue('spinner', $driver));
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
