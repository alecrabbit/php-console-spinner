<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IOptions;
use AlecRabbit\Spinner\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\A\AStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Color\Style;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A\Override\SequencerImplOverride;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AStyleFrameRendererTest extends TestCase
{
    public static function DataProvider(): iterable
    {
        $options = new class() implements IOptions {
        };
        // [$expected, $incoming]
        // #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => LogicException::class,
                    self::MESSAGE => 'Styling is disabled.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => false,
                    self::STYLE => 'red',
                    self::STYLE_MODE => OptionStyleMode::ANSI8,
                ],
            ],
        ];
        // #1
        yield [
            [
                self::RESULT => StaticFrameFactory::create('3-m%s', 0),
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => true,
                    self::STYLE => 196,
                    self::STYLE_MODE => OptionStyleMode::ANSI8,
                ],
            ],
        ];
        // #2
        yield [
            [
                self::RESULT => StaticFrameFactory::create('%s', 0),
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => true,
                    self::STYLE => new Style(), // empty
                    self::STYLE_MODE => OptionStyleMode::ANSI8,
                ],
            ],
        ];
        // #3
        yield [
            [
                self::RESULT => StaticFrameFactory::create('%s', 0),
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => true,
                    self::STYLE => new Style(options: $options),
                    self::STYLE_MODE => OptionStyleMode::ANSI24,
                ],
            ],
        ];
        // #4
        yield [
            [
                self::RESULT => StaticFrameFactory::create('4-m%s', 0),
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => true,
                    self::STYLE => new Style(bgColor: 'red'),
                    self::STYLE_MODE => OptionStyleMode::ANSI24,
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('DataProvider')]
    public function canGiveColorIndexOrHexString(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $renderer = self::getTesteeInstance($args);

        $result = $renderer->render($args[self::STYLE], $args[self::STYLE_MODE]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
    }

    public static function getTesteeInstance(array $args): IStyleFrameRenderer
    {
        $enabled = $args[self::ENABLED];

        $converter = new class($enabled) implements IAnsiStyleConverter {
            public function __construct(
                protected bool $enabled,
            ) {
            }

            public function ansiCode(int|string $color, OptionStyleMode $styleMode): string
            {
                return '-';
            }

            public function isDisabled(): bool
            {
                return !$this->enabled;
            }
        };

        return
            new class($converter, SequencerImplOverride::class) extends AStyleFrameRenderer {
            };
    }
}