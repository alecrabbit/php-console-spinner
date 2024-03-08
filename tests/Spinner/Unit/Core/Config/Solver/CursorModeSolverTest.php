<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\CursorModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class CursorModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mH = CursorMode::HIDDEN;
        $mV = CursorMode::VISIBLE;

        $oAu = CursorOption::AUTO;
        $oHi = CursorOption::HIDDEN;
        $oVi = CursorOption::VISIBLE;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', CursorMode::class),
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

            [[$mH], [$oAu, $oAu, $oHi],], // #22

            [[$mV], [$oVi, $oAu, $oHi],], // #23

            [[$mV], [$oVi, null, $oHi],], // #24
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(CursorModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ICursorModeSolver {
        return
            new CursorModeSolver(
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
            $userCursorOption,
            $detectedCursorOption,
            $defaultCursorOption
        ] = $args;

        $userOutputSettings = $this->getOutputSettingsMock($userCursorOption);
        $detectedOutputSettings = $this->getOutputSettingsMock($detectedCursorOption);
        $defaultOutputSettings = $this->getOutputSettingsMock($defaultCursorOption);

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
        ?CursorOption $cursorOption = null
    ): (MockObject&IOutputSettings)|null {
        return
            $cursorOption === null
                ? null :
                $this->createConfiguredMock(
                    IOutputSettings::class,
                    [
                        'getCursorOption' => $cursorOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
