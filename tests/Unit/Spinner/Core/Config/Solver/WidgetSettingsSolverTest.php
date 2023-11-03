<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\WidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class WidgetSettingsSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
                    ],
                ],
                [null, null, null],
            ],
//            [
//                [
//                    self::EXCEPTION => [
//                        self::CLASS_ => InvalidArgumentException::class,
//                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
//                    ],
//                ],
//                [$oAu, null, null],
//            ],
//            [
//                [
//                    self::EXCEPTION => [
//                        self::CLASS_ => InvalidArgumentException::class,
//                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
//                    ],
//                ],
//                [null, $oAu, null],
//            ],
//            [
//                [
//                    self::EXCEPTION => [
//                        self::CLASS_ => InvalidArgumentException::class,
//                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
//                    ],
//                ],
//                [null, null, $oAu],
//            ],
//            // [result], [$user, $detected, $default]
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

//    #[Test]
//    #[DataProvider('canSolveDataProvider')]
//    public function canSolve(array $expected, array $args): void
//    {
//        $expectedException = $this->expectsException($expected);
//
//        $result = $expected[0] ?? null;
//
//        [
//            $userCursorVisibilityOption,
//            $detectedCursorVisibilityOption,
//            $defaultCursorVisibilityOption
//        ] = $args;
//
//        $userWidgetSettings = $this->getWidgetSettingsMock($userCursorVisibilityOption);
//        $detectedWidgetSettings = $this->getWidgetSettingsMock($detectedCursorVisibilityOption);
//        $defaultWidgetSettings = $this->getWidgetSettingsMock($defaultCursorVisibilityOption);
//
//        $userSettings = $this->getSettingsMock();
//        $userSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(IWidgetSettings::class))
//            ->willReturn($userWidgetSettings)
//        ;
//
//        $detectedSettings = $this->getSettingsMock();
//        $detectedSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(IWidgetSettings::class))
//            ->willReturn($detectedWidgetSettings)
//        ;
//
//        $defaultSettings = $this->getSettingsMock();
//        $defaultSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(IWidgetSettings::class))
//            ->willReturn($defaultWidgetSettings)
//        ;
//
//        $settingsProvider = $this->getSettingsProviderMock();
//
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getUserSettings')
//            ->willReturn($userSettings)
//        ;
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getDetectedSettings')
//            ->willReturn($detectedSettings)
//        ;
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getDefaultSettings')
//            ->willReturn($defaultSettings)
//        ;
//
//        $solver = $this->getTesteeInstance(
//            settingsProvider: $settingsProvider,
//        );
//
//        self::assertSame($result, $solver->solve());
//
//        if ($expectedException) {
//            self::failTest($expectedException);
//        }
//    }

    protected function getWidgetSettingsMock(
        ?CursorVisibilityOption $cursorVisibilityOption = null
    ): (MockObject&IWidgetSettings)|null {
        return
            $cursorVisibilityOption === null
                ? null :
                $this->createConfiguredMock(
                    IWidgetSettings::class,
                    [
                        'getCursorVisibilityOption' => $cursorVisibilityOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
