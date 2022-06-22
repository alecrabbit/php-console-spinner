<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\CharPatternExtractor;
use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\ICharPatternExtractor;
use AlecRabbit\Tests\Spinner\TestCase;

class CharPatternExtractorTest extends TestCase
{
    public function createDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::EXTRACTED => [
                    C::CHARS => [
                        C::FRAMES => [],
                        C::WIDTH => 0,
                        C::INTERVAL => null,
                    ]
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::CHARS => [
                        C::FRAMES => ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'],
                        C::WIDTH => 1,
                        C::INTERVAL => 100,
                    ]
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest02(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::CHARS => [
                        C::FRAMES => ['⣇', '⡏', '⠟', '⠻', '⢹', '⣸', '⣴', '⣦',],
                        C::WIDTH => 1,
                        C::INTERVAL => 150,
                    ]
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest03(),
            ],
        ];

//        yield [
//            [
//                self::EXCEPTION => [
//                    self::_CLASS => InvalidArgumentException::class,
//                    self::MESSAGE =>
//                        sprintf(
//                            'Interval should be less than %s.',
//                            Defaults::MILLISECONDS_MAX_INTERVAL
//                        ),
//                ],
//            ],
//            [],
//        ];
    }

    private static function patternToTest01(): array
    {
        return
            [];
    }

    private static function patternToTest02(): array
    {
        return
            CharPattern::SNAKE_VARIANT_0;
    }


    private static function patternToTest03(): array
    {
        return
            CharPattern::SNAKE_VARIANT_1;
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $extractor = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertEquals($expected[self::EXTRACTED], $extractor->extract($incoming[self::PATTERN]));
    }

    public static function getInstance(array $args = []): ICharPatternExtractor
    {
        return new CharPatternExtractor(...$args);
    }

}
