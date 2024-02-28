<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\WidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetSettingsSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $leadingSpacer = new CharSequenceFrame(' ', 1);
        $trailingSpacer = new CharSequenceFrame(' ', 1);
        $stylePalette = new Rainbow();
        $charPalette = new NoCharPalette();

        $leadingSpacer1 = new CharSequenceFrame(' ', 1);
        $trailingSpacer1 = new CharSequenceFrame(' ', 1);
        $stylePalette1 = new Rainbow();
        $charPalette1 = new NoCharPalette();

        yield from [
            // [Exception], [$user, $detected, $default]
            // #0
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => 'Leading spacer expected to be set.',
                    ],
                ],
                [null, null, null],
            ],
            // #1
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => 'Trailing spacer expected to be set.',
                    ],
                ],
                [
                    null,
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    )
                ],
            ],
            // #2
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => 'Style palette expected to be set.',
                    ],
                ],
                [
                    null,
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    )
                ],
            ],
            // #3
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => 'Char palette expected to be set.',
                    ],
                ],
                [
                    null,
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: null,
                    )
                ],
            ],
            // [result], [$user, $detected, $default]
            // #4
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    )
                ],
            ],
            // #5
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new WidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new WidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: null,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
            ],
            // #6
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new WidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: null,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
            ],
            // #7
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                    null,
                ],
            ],
            // #8
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer1,
                        stylePalette: $stylePalette1,
                        charPalette: $charPalette1,
                    ),
                ],
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer1,
                        stylePalette: $stylePalette1,
                        charPalette: $charPalette1,
                    ),
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
            ],
            // #9
            [
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    null,
                    new WidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettingsSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IWidgetSettingsSolver {
        return
            new WidgetSettingsSolver(
                settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
            );
    }


    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    #[Test]
    #[DataProvider('canSolveDataProvider')]
    public function canSolve(array $expected, array $args): void
    {
        $expectedException = $this->expectsException($expected);

        /** @var IWidgetSettings|null $result */
        $result = $expected[0] ?? null;

        [
            $userWidgetSettings,
            $detectedWidgetSettings,
            $defaultWidgetSettings
        ] = $args;

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IWidgetSettings::class))
            ->willReturn($userWidgetSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IWidgetSettings::class))
            ->willReturn($detectedWidgetSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IWidgetSettings::class))
            ->willReturn($defaultWidgetSettings)
        ;

        $settingsProvider = $this->getSettingsProviderMock();

        $settingsProvider
            ->expects(self::once())
            ->method('getUserSettings')
            ->willReturn($userSettings)
        ;
        $settingsProvider
            ->expects(self::once())
            ->method('getDetectedSettings')
            ->willReturn($detectedSettings)
        ;
        $settingsProvider
            ->expects(self::once())
            ->method('getDefaultSettings')
            ->willReturn($defaultSettings)
        ;

        $solver = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
        );

        $widgetSettings = $solver->solve();

        self::assertEquals($result, $widgetSettings);
        self::assertSame($result->getLeadingSpacer(), $widgetSettings->getLeadingSpacer());
        self::assertSame($result->getTrailingSpacer(), $widgetSettings->getTrailingSpacer());
        self::assertSame($result->getStylePalette(), $widgetSettings->getStylePalette());
        self::assertSame($result->getCharPalette(), $widgetSettings->getCharPalette());

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
