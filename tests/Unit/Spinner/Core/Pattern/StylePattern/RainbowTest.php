<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\StylePattern;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class RainbowTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(Rainbow::class, $factory);
    }

    public function getTesteeInstance(
        ?int $interval = null,
        ?bool $reversed = null
    ): IStylePattern {
        return new Rainbow(
            interval: $interval ?? null,
            reversed: $reversed ?? false,
        );
    }

    #[Test]
    public function throwsIfGetEntriesForStyleModeNone(): void
    {
        $exception = new InvalidArgumentException('Unsupported style mode.');

        $test = function () {
            $rainbow = $this->getTesteeInstance();
            $generator = $rainbow->getEntries(OptionStyleMode::NONE);
            iterator_to_array($generator); // unwrap generator
        };

        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }
}
