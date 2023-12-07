<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config\Factory;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\Spinner\Functional\Override\CharPaletteOverride;
use AlecRabbit\Tests\Spinner\Functional\Override\StylePaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RuntimeWidgetConfigFactoryTest extends TestCase
{
    public static function canCreateDataProvider(): iterable
    {
        yield from [
            // expected, incoming
            // [result], [widgetConfig, widgetSettings]
            [
                [
                    $widgetConfig = new WidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(new PaletteOptions()),
                            charPalette: new CharPaletteOverride(new PaletteOptions()),
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
                    new WidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(new PaletteOptions()),
                            charPalette: $char = new CharPaletteOverride(new PaletteOptions()),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new WidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(new PaletteOptions()),
                            charPalette: new CharPaletteOverride(new PaletteOptions()),
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
                    new WidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(new PaletteOptions()),
                            charPalette: $char = new CharPaletteOverride(new PaletteOptions()),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new WidgetConfig(
                        leadingSpacer: $ls,
                        trailingSpacer: $ts,
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: new StylePaletteOverride(new PaletteOptions()),
                            charPalette: new CharPaletteOverride(new PaletteOptions()),
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
                    new WidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(new PaletteOptions()),
                            charPalette: $char = new CharPaletteOverride(new PaletteOptions()),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new WidgetConfig(
                        leadingSpacer: new CharFrame('', 0),
                        trailingSpacer: $ts,
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style,
                            charPalette: new CharPaletteOverride(new PaletteOptions()),
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
                    new WidgetConfig(
                        leadingSpacer: $ls = new CharFrame('', 0),
                        trailingSpacer: $ts = new CharFrame('', 0),
                        revolverConfig: new WidgetRevolverConfig(
                            stylePalette: $style = new StylePaletteOverride(new PaletteOptions()),
                            charPalette: $char = new CharPaletteOverride(new PaletteOptions()),
                            revolverConfig: $revolverConfig = new RevolverConfig(
                                tolerance: new Tolerance(),
                            ),
                        ),
                    ),
                ],
                [
                    new WidgetConfig(
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

        self::assertInstanceOf(WidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IWidgetConfig $widgetConfig = null,
    ): IInitialWidgetConfigFactory {
        return
            new WidgetConfigFactory(
                widgetConfig: $widgetConfig ?? $this->getWidgetConfigMock(),
            );
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    #[DataProvider('canCreateDataProvider')]
    public function canCreate(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        /** @var IWidgetConfig $expectedConfig */
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
