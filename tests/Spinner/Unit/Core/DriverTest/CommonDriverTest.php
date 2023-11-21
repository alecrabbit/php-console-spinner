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
        self::assertSame($spinnerOne, self::getPropertyValue('spinner', $driver));
        self::assertSame($intervalOne, $driver->getInterval());

        $spinnerTwo = $this->getSpinnerStub();
        $spinnerTwo
            ->method('getInterval')
            ->willReturn($intervalTwo)
        ;

        $driver->add($spinnerTwo);

        self::assertSame($spinnerTwo, self::getPropertyValue('spinner', $driver));
        self::assertSame($intervalTwo, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertNull(self::getPropertyValue('spinner', $driver));
        self::assertSame($initialInterval, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertNull(self::getPropertyValue('spinner', $driver));
        self::assertSame($initialInterval, $driver->getInterval());

        $driver->remove($spinnerOne);

        self::assertNull(self::getPropertyValue('spinner', $driver));
        self::assertSame($initialInterval, $driver->getInterval());
    }
}
