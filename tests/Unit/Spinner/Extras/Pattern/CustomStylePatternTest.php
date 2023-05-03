<?php

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Pattern;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Pattern\CustomStylePattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

/**
 * FIXME (2023-05-03 15:59) [Alec Rabbit]: Unfinished test, tested class purpose is not defined yet.
 */
final class CustomStylePatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(CustomStylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?array $pattern = null,
    ): IStylePattern {
        return new CustomStylePattern(
            pattern: $pattern ?? [
            OptionStyleMode::ANSI4->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
            OptionStyleMode::ANSI8->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
            OptionStyleMode::ANSI24->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
        ],
        );
    }

    #[Test]
    public function throwsIfPatternIsEmpty(): void
    {
        $exception = new InvalidArgumentException('Pattern is empty.');

        $test = function () {
            $this->getTesteeInstance(
                pattern: [],
            );
        };
        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }

    #[Test]
    public function throwsIfPatternIsDoesNotHaveAnsi4Key(): void
    {
        $exception = new InvalidArgumentException('Pattern does not contain ANSI4 key.');

        $test = function () {
            $this->getTesteeInstance(
                pattern: [
//                    OptionStyleMode::ANSI4->value => [],
                    OptionStyleMode::ANSI8->value => [],
                    OptionStyleMode::ANSI24->value => [],
                ],
            );
        };
        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }
}
