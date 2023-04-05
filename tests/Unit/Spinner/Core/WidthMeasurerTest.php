<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\WidthMeasurer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;


final class WidthMeasurerTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canMeasureWidth(): void
    {
        $measurer = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurer::class, $measurer);
        self::assertSame(3, $measurer->getWidth('abc'));
    }

    public function getTesteeInstance(
        ?callable $measureFunction = null
    ): IWidthMeasurer
    {
        return
            new WidthMeasurer(
                measureFunction: $measureFunction ?? static fn(string $string): int => strlen($string)
            );
    }
    #[Test]
    public function throwsIfMeasureFunctionHasInvalidSignature(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Invalid measure function signature. It should be: "function(string $string): int {...}".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $measurer = $this->getTesteeInstance(
            static fn(int $int): string => 'whoops!'
        );

        self::assertInstanceOf(WidthMeasurer::class, $measurer);

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
