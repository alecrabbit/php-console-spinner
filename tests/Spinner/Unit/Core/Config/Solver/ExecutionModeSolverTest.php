<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IExecutionModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\ExecutionModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class ExecutionModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mS = ExecutionMode::SYNCHRONOUS;
        $mA = ExecutionMode::ASYNC;

        $oAu = ExecutionModeOption::AUTO;
        $oSy = ExecutionModeOption::SYNCHRONOUS;
        $oAs = ExecutionModeOption::ASYNC;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', ExecutionMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', ExecutionMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', ExecutionMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', ExecutionMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
            [[$mS], [$oAu, $oSy, $oAs],],
            [[$mA], [$oAu, $oAs, $oAs],],

            [[$mS], [$oSy, $oAs, $oAs],],
            [[$mA], [$oAs, $oAs, $oAs],],

            [[$mA], [$oAs, null, null],],
            [[$mS], [$oSy, null, null],],

            [[$mS], [$oAu, $oSy, null],],
            [[$mA], [$oAu, $oAs, null],],

            [[$mS], [null, $oSy, null],],
            [[$mA], [null, $oAs, null],],

            [[$mS], [$oAu, null, $oSy],],
            [[$mA], [$oAu, null, $oAs],],

            [[$mS], [null, $oAu, $oSy],],
            [[$mA], [null, $oAu, $oAs],],

            [[$mS], [null, $oSy, $oSy],],
            [[$mA], [null, $oAs, $oAs],],

            [[$mS], [null, null, $oSy],],
            [[$mA], [null, null, $oAs],],

            [[$mS], [$oSy, null, $oAs],], // #22
            [[$mA], [$oAs, null, $oAs],], // #23

            [[$mS], [null, $oSy, $oAs],], // #24
            [[$mS], [$oSy, $oSy, $oAs],], // #25
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(ExecutionModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IExecutionModeSolver {
        return
            new ExecutionModeSolver(
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
            $userExecutionModeOption,
            $detectedExecutionModeOption,
            $defaultExecutionModeOption
        ] = $args;

        $userGeneralSettings = $this->getGeneralSettingsMock($userExecutionModeOption);
        $detectedGeneralSettings = $this->getGeneralSettingsMock($detectedExecutionModeOption);
        $defaultGeneralSettings = $this->getGeneralSettingsMock($defaultExecutionModeOption);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IGeneralSettings::class))
            ->willReturn($userGeneralSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IGeneralSettings::class))
            ->willReturn($detectedGeneralSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IGeneralSettings::class))
            ->willReturn($defaultGeneralSettings)
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

    protected function getGeneralSettingsMock(?ExecutionModeOption $executionModeOption = null
    ): (MockObject&IGeneralSettings)|null {
        return
            $executionModeOption === null
                ? null :
                $this->createConfiguredMock(
                    IGeneralSettings::class,
                    [
                        'getExecutionModeOption' => $executionModeOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}