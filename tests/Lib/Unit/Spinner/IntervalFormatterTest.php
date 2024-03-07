<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner;


use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\IntervalFormatter;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

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
            ->willReturn(10.0)
        ;

        self::assertStringContainsString('10ms', $formatter->format($interval));
    }
}
