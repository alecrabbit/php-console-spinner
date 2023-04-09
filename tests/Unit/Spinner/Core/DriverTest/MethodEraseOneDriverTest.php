<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Core\Interval;
use PHPUnit\Framework\Attributes\Test;

final class MethodEraseOneDriverTest extends TestCaseForDriver
{
    #[Test]
    public function cursorEraseIsNotCalledIfNotInitialized(): void
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
    public function cursorEraseCalledIfInitialized(): void
    {
        $driver = $this->getTesteeInstance();
        $driver->initialize();

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
}
