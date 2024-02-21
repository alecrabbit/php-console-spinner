<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RootWidgetSettingsSolverTest extends TestCase
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
            // [result], [$user, $detected, $default]
            // #0
            [
                [
                    new RootWidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                ],
                [null, null, null],
            ],
            // #1
            [
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                ],
                [
                    null,
                    null,
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                ],
                [
                    null,
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    null,
                ],
            ],
            // #3
            [
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: null,
                    )
                ],
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: null,
                    ),
                    null,
                    null,
                ],
            ],
            // #4
            [
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    null,
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new RootWidgetSettings(
                        leadingSpacer: null,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    null,
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer1,
                        stylePalette: $stylePalette1,
                        charPalette: $charPalette1,
                    ),
                ],
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer1,
                        stylePalette: $stylePalette1,
                        charPalette: $charPalette1,
                    ),
                    null,
                    new RootWidgetSettings(
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
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: $trailingSpacer,
                        stylePalette: $stylePalette,
                        charPalette: $charPalette,
                    ),
                ],
                [
                    new RootWidgetSettings(
                        leadingSpacer: $leadingSpacer1,
                        trailingSpacer: null,
                        stylePalette: null,
                        charPalette: null,
                    ),
                    null,
                    new RootWidgetSettings(
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

        self::assertInstanceOf(RootWidgetSettingsSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IRootWidgetSettingsSolver {
        return
            new RootWidgetSettingsSolver(
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

        /** @var IRootWidgetSettings|null $result */
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
            ->with(self::identicalTo(IRootWidgetSettings::class))
            ->willReturn($userWidgetSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRootWidgetSettings::class))
            ->willReturn($detectedWidgetSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRootWidgetSettings::class))
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
