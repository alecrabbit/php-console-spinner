<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\DummyDriver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DummyDriverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(DummyDriver::class, $driver);
    }

    private function getTesteeInstance(
        ?IInterval $initialInterval = null,
    ): IDriver {
        return new DummyDriver(
            initialInterval: $initialInterval ?? $this->getIntervalMock(),
        );
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $driver = $this->getTesteeInstance(
            initialInterval: $interval,
        );

        self::assertSame($interval, $driver->getInterval());
    }

    #[Test]
    public function canHas(): void
    {
        $spinner = $this->getSpinnerMock();

        $driver = $this->getTesteeInstance();

        self::assertFalse($driver->has($spinner));
    }

    private function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    #[Test]
    public function canWrap(): void
    {
        $driver = $this->getTesteeInstance();

        $wrapped =
            $driver->wrap(
            callback: static fn() => throw new \RuntimeException('Should not be called'),
        );

        self::assertNull($wrapped());
    }
}
