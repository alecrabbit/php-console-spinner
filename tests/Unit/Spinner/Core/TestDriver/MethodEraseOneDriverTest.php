<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\TestDriver;

use AlecRabbit\Spinner\Core\Interval;
use PHPUnit\Framework\Attributes\Test;

final class MethodEraseOneDriverTest extends TestCaseForDriver
{
    #[Test]
    public function cursorEraseIsNotCalledIfNotInitialized(): void
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
    public function cursorEraseCalledIfInitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::exactly(2))
            ->method('erase')
        ;

        $driver = $this->getTesteeInstance(cursor: $cursor);
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
