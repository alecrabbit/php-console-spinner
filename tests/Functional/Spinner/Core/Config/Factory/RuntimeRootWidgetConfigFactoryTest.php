<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\Functional\Spinner\Override\CharPaletteOverride;
use AlecRabbit\Tests\Functional\Spinner\Override\StylePaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RuntimeRootWidgetConfigFactoryTest extends TestCase
{
    public static function canCreateDataProvider(): iterable
    {
        yield from [
            // expected, incoming
            // [result], [widgetConfig, widgetSettings]
            [
                [
                    $widgetConfig = new RootWidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(),
                            charPalette: new CharPaletteOverride(),
                            revolverConfig: new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    $widgetConfig,
                    null,
                ],
            ],
            [
                [
                    new RootWidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(),
                            charPalette: $char = new CharPaletteOverride(),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new RootWidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(),
                            charPalette: new CharPaletteOverride(),
                            revolverConfig: $revolverConfig,
                        ),
                    ),
                    new WidgetSettings(
                        leadingSpacer: $ls,
                        trailingSpacer: $ts,
                        stylePalette: $style,
                        charPalette: $char,
                    ),
                ],
            ],
            [
                [
                    new RootWidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(),
                            charPalette: $char = new CharPaletteOverride(),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new RootWidgetConfig(
                        leadingSpacer: $ls,
                        trailingSpacer: $ts,
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(),
                            charPalette: new CharPaletteOverride(),
                            revolverConfig: $revolverConfig,
                        ),
                    ),
                    new WidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: null,
                        stylePalette: $style,
                        charPalette: $char,
                    ),
                ],
            ],
            [
                [
                    new RootWidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(),
                            charPalette: $char = new CharPaletteOverride(),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new RootWidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: $ts,
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style,
                            charPalette: new CharPaletteOverride(),
                            revolverConfig: $revolverConfig,
                        ),
                    ),
                    new WidgetSettings(
                        leadingSpacer: $ls,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: $char,
                    ),
                ],
            ],
            [
                [
                    new RootWidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(),
                            charPalette: $char = new CharPaletteOverride(),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new RootWidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: $ts,
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style,
                            charPalette: $char,
                            revolverConfig: $revolverConfig,
                        ),
                    ),
                    new WidgetSettings(
                        leadingSpacer: $ls,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(RuntimeRootWidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IRootWidgetConfig $widgetConfig = null,
    ): IRootWidgetConfigFactory {
        return
            new RuntimeRootWidgetConfigFactory(
                widgetConfig: $widgetConfig ?? $this->getRootWidgetConfigMock(),
            );
    }

    private function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    #[Test]
    #[DataProvider('canCreateDataProvider')]
    public function canCreate(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        /** @var IRootWidgetConfig $expectedConfig */
        $expectedConfig = $expected[0];

        $factory = $this->getTesteeInstance($incoming[0]);

        $testedConfig = $factory->create($incoming[1]);

        self::assertSame($expectedConfig->getLeadingSpacer(), $testedConfig->getLeadingSpacer());
        self::assertSame($expectedConfig->getTrailingSpacer(), $testedConfig->getTrailingSpacer());

        self::assertSame(
            $expectedConfig->getWidgetRevolverConfig()->getStylePalette(),
            $testedConfig->getWidgetRevolverConfig()->getStylePalette(),
        );
        self::assertSame(
            $expectedConfig->getWidgetRevolverConfig()->getCharPalette(),
            $testedConfig->getWidgetRevolverConfig()->getCharPalette(),
        );
        self::assertSame(
            $expectedConfig->getWidgetRevolverConfig()->getRevolverConfig()->getTolerance(),
            $testedConfig->getWidgetRevolverConfig()->getRevolverConfig()->getTolerance(),
        );

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }
}
