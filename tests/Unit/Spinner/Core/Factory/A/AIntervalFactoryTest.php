<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntNormalizer;
use AlecRabbit\Spinner\Core\Factory\A\AIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\IntNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AIntervalFactoryTest extends TestCase
{
    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // divisor, result, interval,
            [50, 100, 100,],
            [10, 100, 100,],
            [100, 100, 100,],
            [100, 400, 400,],
            [50, 500, 490,],
            [50, 450, 450,],
            [50, 500, 475,],
            [50, 450, 474,],
            [1000, 10, 474,],
            [1000, 1000, 500,],
        ];
    }

    public static function createNormalizedIntervalData(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::INTERVAL => 100, // result
            ],
            [
                self::ARGUMENTS => [
                    self::INTERVAL => 120, // interval
                    self::DIVISOR => 50, // divisor
                ],
            ],
        ];
        foreach (self::simplifiedDataFeeder() as $item) {
            yield [
                [
                    self::INTERVAL => $item[1], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::INTERVAL => $item[2], // interval
                        self::DIVISOR => $item[0], // divisor
                    ],
                ],
            ];
        }
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be greater than 0.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::DIVISOR => 0,
//                ],
//            ],
//        ];
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be less than 1000.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::DIVISOR => 1200,
//                ],
//            ],
//        ];
    }

    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $defaults = DefaultsFactory::create();

        self::assertEquals(
            $defaults->getIntervalMilliseconds(),
            AIntervalFactory::createDefault()->toMilliseconds()
        );
    }

    #[Test]
    #[DataProvider('createNormalizedIntervalData')]
    public function canCreateNormalizedInterval(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $args = $incoming[self::ARGUMENTS];

        IntNormalizer::setDivisor($args[self::DIVISOR]);

        self::assertEquals(
            $expected[self::INTERVAL],
            AIntervalFactory::createNormalized($args[self::INTERVAL])->toMilliseconds()
        );
    }

    protected function setUp(): void
    {
        IntNormalizer::setDivisor(IIntNormalizer::DEFAULT_DIVISOR);
        IntNormalizer::setMin(IInterval::MIN_INTERVAL_MILLISECONDS);
    }
}
