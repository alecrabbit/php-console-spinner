<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Stopwatch\ResultShortFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ResultShortFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(ResultShortFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IResultFormatter
    {
        return
            new ResultShortFormatter();
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

        self::assertEquals('1.00μs', $formatter->format($result));
    }

    private function getResultMock(): MockObject&IResult
    {
        return $this->createMock(IResult::class);
    }
}
