<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RunMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class RunMethodModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mS = RunMethodMode::SYNCHRONOUS;
        $mA = RunMethodMode::ASYNC;

        $oAu = RunMethodOption::AUTO;
        $oSy = RunMethodOption::SYNCHRONOUS;
        $oAs = RunMethodOption::ASYNC;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', RunMethodMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', RunMethodMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', RunMethodMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', RunMethodMode::class),
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

        self::assertInstanceOf(RunMethodModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IRunMethodModeSolver {
        return
            new RunMethodModeSolver(
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
            $userRunMethodOption,
            $detectedRunMethodOption,
            $defaultRunMethodOption
        ] = $args;

        $userGeneralSettings = $this->getGeneralSettingsMock($userRunMethodOption);
        $detectedGeneralSettings = $this->getGeneralSettingsMock($detectedRunMethodOption);
        $defaultGeneralSettings = $this->getGeneralSettingsMock($defaultRunMethodOption);

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

    protected function getGeneralSettingsMock(?RunMethodOption $runMethodOption = null
    ): (MockObject&IGeneralSettings)|null {
        return
            $runMethodOption === null
                ? null :
                $this->createConfiguredMock(
                    IGeneralSettings::class,
                    [
                        'getRunMethodOption' => $runMethodOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
