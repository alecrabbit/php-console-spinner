<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\A\AStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Color\Ansi8Color;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AStyleFrameRendererTest extends TestCase
{
    public static function DataProvider(): iterable
    {
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
                    self::STYLE_MODE => StyleMode::ANSI8,
                ],
            ],
        ];
        // #1
        yield [
            [
                self::RESULT => FrameFactory::create("\e[3-m%s\e[0m", 0),
            ],
            [
                self::ARGUMENTS => [
                    self::ENABLED => true,
                    self::STYLE => 196,
                    self::STYLE_MODE => StyleMode::ANSI8,
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
            self::exceptionNotThrown(
                $expectedException,
                dataSet: [$result, $expected, $incoming]
            );
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    public static function getTesteeInstance(array $args): IStyleFrameRenderer
    {
        $enabled = $args[self::ENABLED];

        $converter = new class($enabled) implements IAnsiStyleConverter {
            public function __construct(
                protected bool $enabled,
            ) {
            }

            public function ansiCode(int|string $color, StyleMode $styleMode): string
            {
                return '-';
            }

            public function isDisabled(): bool
            {
                return !$this->enabled;
            }
        };
        return
            new class($converter) extends AStyleFrameRenderer {
            };
    }
}


