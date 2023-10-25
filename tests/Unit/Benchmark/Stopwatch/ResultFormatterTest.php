<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Stopwatch\ResultFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ResultFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(ResultFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IResultFormatter
    {
        return
            new ResultFormatter();
    }

    #[Test]
    public function canFormatWithAverage(): void
    {
        $formatter = $this->getTesteeInstance();

        $result =
            $this->getResultMock();

        $result
            ->expects(self::once())
            ->method('getAverage')
            ->willReturn(1.0)
        ;
        $result
            ->expects(self::once())
            ->method('getMax')
            ->willReturn(1.0)
        ;
        $result
            ->expects(self::once())
            ->method('getMin')
            ->willReturn(1.0)
        ;

        self::assertEquals('1.00μs [1.00μs/1.00μs]', $formatter->format($result));
    }

    private function getResultMock(): MockObject&IResult
    {
        return $this->createMock(IResult::class);
    }
}
