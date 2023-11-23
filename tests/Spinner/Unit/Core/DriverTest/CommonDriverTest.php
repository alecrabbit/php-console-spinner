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
