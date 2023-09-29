<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Legacy\StylePattern;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\StylePattern\Rainbow;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class RainbowTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(Rainbow::class, $factory);
    }

    public function getTesteeInstance(
        ?int $interval = null,
        ?bool $reversed = null
    ): IStyleLegacyPattern {
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
            $generator = $rainbow->getEntries(StylingMethodOption::NONE);
            iterator_to_array($generator); // unwrap generator
        };

        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }
}
