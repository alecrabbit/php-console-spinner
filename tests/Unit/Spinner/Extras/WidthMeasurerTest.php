<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\WidthMeasurer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidthMeasurerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canMeasureWidth(): void
    {
        $measurer = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurer::class, $measurer);
        self::assertSame(3, $measurer->measureWidth('abc'));
    }

    public function getTesteeInstance(
        ?callable $measureFunction = null
    ): IWidthMeasurer {
        return new WidthMeasurer(
            measureFunction: $measureFunction ?? static fn(string $string): int => strlen($string)
        );
    }

    #[Test]
    public function throwsIfMeasureFunctionHasInvalidSignature(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage =
            'Invalid measure function signature.'
            . ' Signature expected to be: "function(string $string): int { //... }".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $measurer = $this->getTesteeInstance(
            static fn(int $int): string => 'whoops!'
        );

        self::assertInstanceOf(WidthMeasurer::class, $measurer);

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
