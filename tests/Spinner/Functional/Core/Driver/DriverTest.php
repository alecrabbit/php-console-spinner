<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Driver;

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalComparator;
use AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest\TestCaseForDriver;
use PHPUnit\Framework\Attributes\Test;

final class DriverTest extends TestCaseForDriver
{
    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $initialInterval = new Interval(2000);
        $intervalOne = new Interval(1200);
        $intervalTwo = new Interval(135);

        $driver = $this->getTesteeInstance(
            initialInterval: $initialInterval,
            intervalComparator: new IntervalComparator(),
        );

        $spinnerOne = $this->getSpinnerStub();
        $spinnerOne
            ->method('getInterval')
            ->willReturn($intervalOne)
        ;

        $spinnerTwo = $this->getSpinnerStub();
        $spinnerTwo
            ->method('getInterval')
            ->willReturn($intervalTwo)
        ;

        $driver->add($spinnerOne);
        self::assertTrue($driver->has($spinnerOne));
        self::assertFalse($driver->has($spinnerTwo));
        self::assertSame($intervalOne, $driver->getInterval());

        $driver->add($spinnerTwo);

        self::assertFalse($driver->has($spinnerOne));
        self::assertTrue($driver->has($spinnerTwo));
        self::assertSame($intervalTwo, $driver->getInterval());

        $driver->remove($spinnerTwo);

        self::assertFalse($driver->has($spinnerOne));
        self::assertFalse($driver->has($spinnerTwo));
        self::assertSame($initialInterval, $driver->getInterval());

        $driver->remove($spinnerOne);

        self::assertSame($initialInterval, $driver->getInterval());
    }
}
