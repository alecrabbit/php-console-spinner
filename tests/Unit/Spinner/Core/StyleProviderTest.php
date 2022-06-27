<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\IStyleProvider;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\Factory\StyleFrameFactory;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleProvider;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;
use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_TRUECOLOR;

class StyleProviderTest extends TestCase
{
    public function canProvideDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::PROVIDED => [
                    C::FRAMES => [
                        StyleFrame::createEmpty(),
                    ],
                    C::INTERVAL => Interval::createDefault(),
                ],
            ],
            [
                self::ARGUMENTS => [],
                self::PATTERN => self::patternToTest01(),
            ],
        ];

        yield [
            [
                self::PROVIDED => [
                    C::FRAMES => [
                        new StyleFrame(CSI . '96m', RESET),
                    ],
                    C::INTERVAL => Interval::createDefault(),
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
                self::PROVIDED => [
                    C::FRAMES => [
                        new StyleFrame(CSI . '38;5;196m', RESET),
                        new StyleFrame(CSI . '38;5;202m', RESET),
                        new StyleFrame(CSI . '38;5;208m', RESET),
                        new StyleFrame(CSI . '38;5;214m', RESET),
                        new StyleFrame(CSI . '38;5;220m', RESET),
                        new StyleFrame(CSI . '38;5;226m', RESET),
                        new StyleFrame(CSI . '38;5;190m', RESET),
                        new StyleFrame(CSI . '38;5;154m', RESET),
                        new StyleFrame(CSI . '38;5;118m', RESET),
                        new StyleFrame(CSI . '38;5;82m', RESET),
                        new StyleFrame(CSI . '38;5;46m', RESET),
                        new StyleFrame(CSI . '38;5;47m', RESET),
                        new StyleFrame(CSI . '38;5;48m', RESET),
                        new StyleFrame(CSI . '38;5;49m', RESET),
                        new StyleFrame(CSI . '38;5;50m', RESET),
                        new StyleFrame(CSI . '38;5;51m', RESET),
                        new StyleFrame(CSI . '38;5;45m', RESET),
                        new StyleFrame(CSI . '38;5;39m', RESET),
                        new StyleFrame(CSI . '38;5;33m', RESET),
                        new StyleFrame(CSI . '38;5;27m', RESET),
                        new StyleFrame(CSI . '38;5;56m', RESET),
                        new StyleFrame(CSI . '38;5;57m', RESET),
                        new StyleFrame(CSI . '38;5;93m', RESET),
                        new StyleFrame(CSI . '38;5;129m', RESET),
                        new StyleFrame(CSI . '38;5;165m', RESET),
                        new StyleFrame(CSI . '38;5;201m', RESET),
                        new StyleFrame(CSI . '38;5;200m', RESET),
                        new StyleFrame(CSI . '38;5;199m', RESET),
                        new StyleFrame(CSI . '38;5;198m', RESET),
                        new StyleFrame(CSI . '38;5;197m', RESET),
                    ],
                    C::INTERVAL => new Interval(200),
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
                self::PROVIDED => [
                    C::FRAMES => [
                        new StyleFrame(CSI . '38;5;232;48;5;196m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;202m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;208m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;214m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;220m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;226m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;190m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;154m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;118m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;82m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;46m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;47m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;48m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;49m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;50m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;51m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;45m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;39m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;33m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;27m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;56m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;57m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;93m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;129m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;165m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;201m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;200m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;199m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;198m', RESET),
                        new StyleFrame(CSI . '38;5;232;48;5;197m', RESET),
                    ],
                    C::INTERVAL => new Interval(200),
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
                self::PROVIDED => [
                    C::FRAMES => [
                        new StyleFrame(CSI . '38;5;196m', RESET),
                        new StyleFrame(CSI . '38;5;202m', RESET),
                        new StyleFrame(CSI . '38;5;208m', RESET),
                        new StyleFrame(CSI . '38;5;214m', RESET),
                        new StyleFrame(CSI . '38;5;220m', RESET),
                        new StyleFrame(CSI . '38;5;226m', RESET),
                        new StyleFrame(CSI . '38;5;190m', RESET),
                        new StyleFrame(CSI . '38;5;154m', RESET),
                        new StyleFrame(CSI . '38;5;118m', RESET),
                        new StyleFrame(CSI . '38;5;82m', RESET),
                        new StyleFrame(CSI . '38;5;46m', RESET),
                        new StyleFrame(CSI . '38;5;47m', RESET),
                        new StyleFrame(CSI . '38;5;48m', RESET),
                        new StyleFrame(CSI . '38;5;49m', RESET),
                        new StyleFrame(CSI . '38;5;50m', RESET),
                        new StyleFrame(CSI . '38;5;51m', RESET),
                        new StyleFrame(CSI . '38;5;45m', RESET),
                        new StyleFrame(CSI . '38;5;39m', RESET),
                        new StyleFrame(CSI . '38;5;33m', RESET),
                        new StyleFrame(CSI . '38;5;27m', RESET),
                        new StyleFrame(CSI . '38;5;56m', RESET),
                        new StyleFrame(CSI . '38;5;57m', RESET),
                        new StyleFrame(CSI . '38;5;93m', RESET),
                        new StyleFrame(CSI . '38;5;129m', RESET),
                        new StyleFrame(CSI . '38;5;165m', RESET),
                        new StyleFrame(CSI . '38;5;201m', RESET),
                        new StyleFrame(CSI . '38;5;200m', RESET),
                        new StyleFrame(CSI . '38;5;199m', RESET),
                        new StyleFrame(CSI . '38;5;198m', RESET),
                        new StyleFrame(CSI . '38;5;197m', RESET),
                    ],
                    C::INTERVAL => new Interval(200),
                ],
            ],
            [
                self::ARGUMENTS => [
                    TERM_TRUECOLOR,
                ],
                self::PATTERN => self::patternToTest01(),
            ],
        ];
    }

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

    /**
     * @test
     * @dataProvider canProvideDataProvider
     */
    public function canProvide(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $renderer = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertEquals($expected[self::PROVIDED], $renderer->provide($incoming[self::PATTERN]));
    }

    public static function getInstance(array $args = []): IStyleProvider
    {
        return
            new StyleProvider(
                self::getFrameFactoryInstance($args),
                self::getExtractorInstance($args)
            );
    }

    private static function getFrameFactoryInstance(array $args = []): StyleFrameFactory
    {
        return new StyleFrameFactory();
    }

    public static function getExtractorInstance(array $args = []): IStylePatternExtractor
    {
        return new StylePatternExtractor(...$args);
    }

}
