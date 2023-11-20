<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Lib\Spinner\Core;


use AlecRabbit\Lib\Spinner\Core\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Core\IntervalFormatter;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class IntervalFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();
        self::assertInstanceOf(IntervalFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IIntervalFormatter
    {
        return new IntervalFormatter();
    }

    #[Test]
    public function canFormat(): void
    {
        $formatter = $this->getTesteeInstance();

        $interval = $this->createMock(IInterval::class);
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(10.0);

        $object = $this->getHasIntervalMock();
        $object
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        self::assertStringContainsString('Interval: 10ms', $formatter->format($object));
    }

    private function getHasIntervalMock(): MockObject&IHasInterval
    {
        return $this->createMock(IHasInterval::class);
    }
}
