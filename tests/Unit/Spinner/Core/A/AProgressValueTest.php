<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\A\AProgressValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AProgressValueTest extends TestCase
{
    public static function createDataProvider(): iterable
    {
        yield from self::createNormalData();
        yield from self::createExceptionData();
    }

    public static function createNormalData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::FINISHED => false,
                self::VALUE => 0.0,
                self::MIN => 0.0,
                self::MAX => 1.0,
                self::STEPS => 100,
            ],
            [
                self::ARGUMENTS => [
                    self::START => 0,
                    self::MIN => 0,
                    self::MAX => 1,
                    self::STEPS => 100,
                ],
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => $startValue = 0.34,
                self::STEPS => 100,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START => $startValue,
                ],
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => 0.69,
                self::STEPS => 100,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START => 0.35,
                ],
                self::STEPS => 34,
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => 0.52,
                self::STEPS => 200,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START => 0.35,
                    self::STEPS => 200
                ],
                self::STEPS => 34,
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => -0.9,
                self::STEPS => 200,
                self::MIN => -1.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START => -1.0,
                    self::STEPS => 200,
                    self::MIN => -1.0,
                    self::MAX => 1.0
                ],
                self::STEPS => 10,
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => 1.0,
                self::STEPS => 100,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [],
                self::STEPS => 110,
            ],
        ];
        yield [
            [
                self::FINISHED => false,
                self::VALUE => 0.0,
                self::STEPS => 100,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [],
                self::STEPS => -10,
            ],
        ];
        yield [
            [
                self::FINISHED => true,
                self::VALUE => 1.0,
                self::STEPS => 100,
                self::MIN => 0.0,
                self::MAX => 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START => 0.95,
                    self::AUTO_FINISH => true,
                ],
                self::STEPS => 20,
            ],
        ];
    }

    public static function createExceptionData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Steps should be greater than 0. Steps: "%s".',
                            $steps = -2
                        ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::STEPS => $steps,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Steps should be greater than 0. Steps: "%s".',
                            $steps = 0
                        ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::STEPS => $steps,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Max value should be greater than min value. Min: "%s", Max: "%s".',
                            $min = 1,
                            $max = 0
                        ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MIN => $min,
                    self::MAX => $max,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        'Min and Max values cannot be equal.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MIN => 1,
                    self::MAX => 1,
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $fractionValue = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        if (isset($incoming[self::STEPS])) {
            $steps = abs($incoming[self::STEPS]);
            $step = $incoming[self::STEPS] < 0 ? -1 : 1;
            for ($i = 0; $i < $steps; $i++) {
                $fractionValue->advance($step);
            }
        }

        self::assertEqualsWithDelta(
            $expected[self::VALUE],
            $fractionValue->getValue(),
            self::FLOAT_EQUALITY_DELTA
        );

        self::assertSame($expected[self::FINISHED], $fractionValue->isFinished());
        self::assertSame($expected[self::MIN], $fractionValue->getMin());
        self::assertSame($expected[self::MAX], $fractionValue->getMax());
        self::assertSame($expected[self::STEPS], $fractionValue->getSteps());
    }

    public static function getInstance(array $args = []): IProgressValue
    {
        return new class(
            startValue: $args[self::START] ?? 0.0,
            steps: $args[self::STEPS] ?? 100,
            min: $args[self::MIN] ?? 0.0,
            max: $args[self::MAX] ?? 1.0,
            autoFinish: $args[self::AUTO_FINISH] ?? false,
        ) extends AProgressValue {
        };
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function canBeFinished(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $fractionValue = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        if (isset($incoming[self::STEPS])) {
            $steps = abs($incoming[self::STEPS]);
            $step = $incoming[self::STEPS] < 0 ? -1 : 1;
            for ($i = 0; $i < $steps; $i++) {
                $fractionValue->advance($step);
            }
        }

        self::assertEqualsWithDelta(
            $expected[self::VALUE],
            $fractionValue->getValue(),
            self::FLOAT_EQUALITY_DELTA
        );

        self::assertSame($expected[self::FINISHED], $fractionValue->isFinished());
        self::assertSame($expected[self::MIN], $fractionValue->getMin());
        self::assertSame($expected[self::MAX], $fractionValue->getMax());
        self::assertSame($expected[self::STEPS], $fractionValue->getSteps());

        $fractionValue->finish();

        self::assertTrue($fractionValue->isFinished());
    }

}
