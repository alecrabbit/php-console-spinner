<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleRenderer;
use AlecRabbit\Tests\Spinner\TestCase;

use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_16COLOR;
use const AlecRabbit\Cli\TERM_256COLOR;
use const AlecRabbit\Cli\TERM_NOCOLOR;
use const AlecRabbit\Cli\TERM_TRUECOLOR;

class StyleRendererTest extends TestCase
{
    #[ArrayShape([C::STYLES => "array[]", C::INTERVAL => "int"])]
    private static function patternToTest01(): array
    {
        return
            StylePattern::rainbow();
    }

    public function renderDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::EXTRACTED => [
                    C::STYLES => [
                        C::SEQUENCE => [],
                        C::FORMAT => '',
                    ],
                    C::INTERVAL => 1000,
                ],
            ],
            [
                self::ARGUMENTS => [],
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
        $this->checkForExceptionExpectance($expected);

        $renderer = self::getInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertEquals($expected[self::EXTRACTED], $renderer->render($incoming[self::PATTERN]));
    }

    public static function getInstance(array $args = []): IStyleRenderer
    {
        return new StyleRenderer(self::getExtractorInstance(...$args));
    }

    public static function getExtractorInstance(array $args = []): IStylePatternExtractor
    {
        return new StylePatternExtractor(...$args);
    }

}
