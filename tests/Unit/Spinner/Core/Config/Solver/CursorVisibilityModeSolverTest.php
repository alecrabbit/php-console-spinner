<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\CursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class CursorVisibilityModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mH = CursorVisibilityMode::HIDDEN;
        $mV = CursorVisibilityMode::VISIBLE;

        $oAu = CursorVisibilityOption::AUTO;
        $oHi = CursorVisibilityOption::HIDDEN;
        $oVi = CursorVisibilityOption::VISIBLE;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorVisibilityMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
            [[$mH], [$oAu, $oHi, $oVi],],
            [[$mV], [$oAu, $oVi, $oVi],],

            [[$mH], [$oHi, $oVi, $oVi],],
            [[$mV], [$oVi, $oVi, $oVi],],

            [[$mV], [$oVi, null, null],],
            [[$mH], [$oHi, null, null],],

            [[$mH], [$oAu, $oHi, null],],
            [[$mV], [$oAu, $oVi, null],],

            [[$mH], [null, $oHi, null],],
            [[$mV], [null, $oVi, null],],

            [[$mH], [$oAu, null, $oHi],],
            [[$mV], [$oAu, null, $oVi],],

            [[$mH], [null, $oAu, $oHi],],
            [[$mV], [null, $oAu, $oVi],],

            [[$mH], [null, $oHi, $oHi],],
            [[$mV], [null, $oVi, $oVi],],

            [[$mH], [null, null, $oHi],],
            [[$mV], [null, null, $oVi],],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(CursorVisibilityModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ICursorVisibilityModeSolver {
        return
            new CursorVisibilityModeSolver(
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

        $result = $expected[0] ?? null;

        [
            $userCursorVisibilityOption,
            $detectedCursorVisibilityOption,
            $defaultCursorVisibilityOption
        ] = $args;

        $userOutputSettings = $this->getOutputSettingsMock($userCursorVisibilityOption);
        $detectedOutputSettings = $this->getOutputSettingsMock($detectedCursorVisibilityOption);
        $defaultOutputSettings = $this->getOutputSettingsMock($defaultCursorVisibilityOption);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IOutputSettings::class))
            ->willReturn($userOutputSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IOutputSettings::class))
            ->willReturn($detectedOutputSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IOutputSettings::class))
            ->willReturn($defaultOutputSettings)
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

        self::assertSame($result, $solver->solve());

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    protected function getOutputSettingsMock(
        ?CursorVisibilityOption $cursorVisibilityOption = null
    ): (MockObject&IOutputSettings)|null {
        return
            $cursorVisibilityOption === null
                ? null :
                $this->createConfiguredMock(
                    IOutputSettings::class,
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
