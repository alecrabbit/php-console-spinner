<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
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
        self::assertFalse(self::getValue('active', $driver));
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
    public function canBeInitialized(): void
    {
        $driver = $this->getTesteeInstance();

        $driver->initialize();

        self::assertTrue(self::getValue('active', $driver));
    }

    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $driver = $this->getTesteeInstance();

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
    public function throwsIfInvalidIntervalCallbackProvided(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage =
            'Interval callback MUST return an instance of "'
            . IInterval::class
            . '", instead returns "null".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $_ =
            $this->getTesteeInstance(
                intervalCb: fn() => null
            );

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
