<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Tests\Spinner\TestCase;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_NOCOLOR;
use const AlecRabbit\Cli\TERM_TRUECOLOR;

class StylePatternExtractorTest extends TestCase
{
    public function createDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                        C::INTERVAL => null,
                    ],
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
                    C::STYLES => [
                        C::SEQUENCE => [],
                        C::FORMAT => null,
                        C::INTERVAL => null,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest03(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [96],
                        C::FORMAT => '%s',
                        C::INTERVAL => null,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_16COLOR
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [195, 196, 196, 196, 196, 196, 196, 196, 196],
                        C::FORMAT => '38;5;%s',
                        C::INTERVAL => 1000,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_256COLOR
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [201, 201, 201, 201, 201, 201, 201, 201, 201],
                        C::FORMAT => '38;5;%s',
                        C::INTERVAL => 1000,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_TRUECOLOR
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [
                            196,
                            202,
                            208,
                            214,
                            220,
                            226,
                            190,
                            154,
                            118,
                            82,
                            46,
                            47,
                            48,
                            49,
                            50,
                            51,
                            45,
                            39,
                            33,
                            27,
                            56,
                            57,
                            93,
                            129,
                            165,
                            201,
                            200,
                            199,
                            198,
                            197,
                        ],
                        C::FORMAT => '38;5;%sm',
                        C::INTERVAL => 200,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_256COLOR
                ],
                self::PATTERN => self::patternToTest02(),
            ],
        ];

        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [
                            196,
                            202,
                            208,
                            214,
                            220,
                            226,
                            190,
                            154,
                            118,
                            82,
                            46,
                            47,
                            48,
                            49,
                            50,
                            51,
                            45,
                            39,
                            33,
                            27,
                            56,
                            57,
                            93,
                            129,
                            165,
                            201,
                            200,
                            199,
                            198,
                            197,
                        ],
                        C::FORMAT => '38;5;%sm',
                        C::INTERVAL => 200,
                    ],
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_TRUECOLOR
                ],
                self::PATTERN => self::patternToTest02(),
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

    #[ArrayShape([C::STYLES => "array[]"])]
    private static function patternToTest01(): array
    {
        return
            [
                C::STYLES => [
                    TERM_NOCOLOR =>
                        [
                            C::SEQUENCE => [],
                            C::FORMAT => '',
                            C::INTERVAL => null,
                        ],
                    TERM_16COLOR =>
                        [
                            C::SEQUENCE => [96],
                            C::FORMAT => '%s',
                            C::INTERVAL => null,
                        ],
                    TERM_256COLOR =>
                        [
                            C::SEQUENCE => [195, 196, 196, 196, 196, 196, 196, 196, 196],
                            C::FORMAT => '38;5;%s',
                            C::INTERVAL => 1000,
                        ],
                    TERM_TRUECOLOR =>
                        [
                            C::SEQUENCE => [201, 201, 201, 201, 201, 201, 201, 201, 201],
                            C::FORMAT => '38;5;%s',
                            C::INTERVAL => 1000,
                        ],
                ],
            ];
    }

    #[ArrayShape([C::STYLES => "array[]"])]
    private static function patternToTest02(): array
    {
        return
            StylePattern::rainbow();
    }

    #[ArrayShape([C::STYLES => "array[]"])]
    private static function patternToTest03(): array
    {
        return
            [
                C::STYLES => [],
            ];
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

    public static function getInstance(array $args = []): IStylePatternExtractor
    {
        return new StylePatternExtractor(...$args);
    }

}
