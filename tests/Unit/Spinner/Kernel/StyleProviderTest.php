<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Kernel\Contract\WIStyleProvider;
use AlecRabbit\Spinner\Kernel\StylePatternExtractor;
use AlecRabbit\Spinner\Kernel\WStyleProvider;
use AlecRabbit\Tests\Spinner\TestCase;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;
use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_TRUECOLOR;

class StyleProviderTest extends TestCase
{
    #[ArrayShape([C::STYLES => "array[]"])]
    private static function patternToTest01(): array
    {
        return
            StylePattern::rainbow();
    }

    #[ArrayShape([C::STYLES => "array[]"])]
    private static function patternToTest02(): array
    {
        return
            StylePattern::rainbowBg();
    }

    public function renderDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::RENDERED => [
                    C::STYLES => [],
                    C::INTERVAL => null,
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::RENDERED => [
                    C::STYLES => [
                        CSI . '96m%s' . RESET,
                    ],
                    C::INTERVAL => null,
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_16COLOR,
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::RENDERED => [
                    C::STYLES => [
                        CSI . '38;5;196m%s' . RESET,
                        CSI . '38;5;202m%s' . RESET,
                        CSI . '38;5;208m%s' . RESET,
                        CSI . '38;5;214m%s' . RESET,
                        CSI . '38;5;220m%s' . RESET,
                        CSI . '38;5;226m%s' . RESET,
                        CSI . '38;5;190m%s' . RESET,
                        CSI . '38;5;154m%s' . RESET,
                        CSI . '38;5;118m%s' . RESET,
                        CSI . '38;5;82m%s' . RESET,
                        CSI . '38;5;46m%s' . RESET,
                        CSI . '38;5;47m%s' . RESET,
                        CSI . '38;5;48m%s' . RESET,
                        CSI . '38;5;49m%s' . RESET,
                        CSI . '38;5;50m%s' . RESET,
                        CSI . '38;5;51m%s' . RESET,
                        CSI . '38;5;45m%s' . RESET,
                        CSI . '38;5;39m%s' . RESET,
                        CSI . '38;5;33m%s' . RESET,
                        CSI . '38;5;27m%s' . RESET,
                        CSI . '38;5;56m%s' . RESET,
                        CSI . '38;5;57m%s' . RESET,
                        CSI . '38;5;93m%s' . RESET,
                        CSI . '38;5;129m%s' . RESET,
                        CSI . '38;5;165m%s' . RESET,
                        CSI . '38;5;201m%s' . RESET,
                        CSI . '38;5;200m%s' . RESET,
                        CSI . '38;5;199m%s' . RESET,
                        CSI . '38;5;198m%s' . RESET,
                        CSI . '38;5;197m%s' . RESET,
                    ],
                    C::INTERVAL => 200,
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_256COLOR,
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::RENDERED => [
                    C::STYLES => [
                        CSI . '48;5;196m%s' . RESET,
                        CSI . '48;5;202m%s' . RESET,
                        CSI . '48;5;208m%s' . RESET,
                        CSI . '48;5;214m%s' . RESET,
                        CSI . '48;5;220m%s' . RESET,
                        CSI . '48;5;226m%s' . RESET,
                        CSI . '48;5;190m%s' . RESET,
                        CSI . '48;5;154m%s' . RESET,
                        CSI . '48;5;118m%s' . RESET,
                        CSI . '48;5;82m%s' . RESET,
                        CSI . '48;5;46m%s' . RESET,
                        CSI . '48;5;47m%s' . RESET,
                        CSI . '48;5;48m%s' . RESET,
                        CSI . '48;5;49m%s' . RESET,
                        CSI . '48;5;50m%s' . RESET,
                        CSI . '48;5;51m%s' . RESET,
                        CSI . '48;5;45m%s' . RESET,
                        CSI . '48;5;39m%s' . RESET,
                        CSI . '48;5;33m%s' . RESET,
                        CSI . '48;5;27m%s' . RESET,
                        CSI . '48;5;56m%s' . RESET,
                        CSI . '48;5;57m%s' . RESET,
                        CSI . '48;5;93m%s' . RESET,
                        CSI . '48;5;129m%s' . RESET,
                        CSI . '48;5;165m%s' . RESET,
                        CSI . '48;5;201m%s' . RESET,
                        CSI . '48;5;200m%s' . RESET,
                        CSI . '48;5;199m%s' . RESET,
                        CSI . '48;5;198m%s' . RESET,
                        CSI . '48;5;197m%s' . RESET,
                    ],
                    C::INTERVAL => 200,
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_256COLOR,
                ],
                self::PATTERN => self::patternToTest02(),
            ],
        ];

        yield [
            [
                self::RENDERED => [
                    C::STYLES => [
                        CSI . '38;5;196m%s' . RESET,
                        CSI . '38;5;202m%s' . RESET,
                        CSI . '38;5;208m%s' . RESET,
                        CSI . '38;5;214m%s' . RESET,
                        CSI . '38;5;220m%s' . RESET,
                        CSI . '38;5;226m%s' . RESET,
                        CSI . '38;5;190m%s' . RESET,
                        CSI . '38;5;154m%s' . RESET,
                        CSI . '38;5;118m%s' . RESET,
                        CSI . '38;5;82m%s' . RESET,
                        CSI . '38;5;46m%s' . RESET,
                        CSI . '38;5;47m%s' . RESET,
                        CSI . '38;5;48m%s' . RESET,
                        CSI . '38;5;49m%s' . RESET,
                        CSI . '38;5;50m%s' . RESET,
                        CSI . '38;5;51m%s' . RESET,
                        CSI . '38;5;45m%s' . RESET,
                        CSI . '38;5;39m%s' . RESET,
                        CSI . '38;5;33m%s' . RESET,
                        CSI . '38;5;27m%s' . RESET,
                        CSI . '38;5;56m%s' . RESET,
                        CSI . '38;5;57m%s' . RESET,
                        CSI . '38;5;93m%s' . RESET,
                        CSI . '38;5;129m%s' . RESET,
                        CSI . '38;5;165m%s' . RESET,
                        CSI . '38;5;201m%s' . RESET,
                        CSI . '38;5;200m%s' . RESET,
                        CSI . '38;5;199m%s' . RESET,
                        CSI . '38;5;198m%s' . RESET,
                        CSI . '38;5;197m%s' . RESET,
                    ],
                    C::INTERVAL => 200,
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_TRUECOLOR,
                ],
                self::PATTERN => self::patternToTest01(),
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

    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $renderer = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertEquals($expected[self::RENDERED], $renderer->provide($incoming[self::PATTERN]));
    }

    public static function getInstance(array $args = []): WIStyleProvider
    {
        return new WStyleProvider(self::getExtractorInstance($args));
    }

    public static function getExtractorInstance(array $args = []): IStylePatternExtractor
    {
        return new StylePatternExtractor(...$args);
    }

}
