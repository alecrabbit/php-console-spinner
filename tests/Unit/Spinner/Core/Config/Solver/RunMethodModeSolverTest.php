<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RunMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RunMethodModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mS = RunMethodMode::SYNCHRONOUS;
        $mA = RunMethodMode::ASYNC;

        $oAut = RunMethodOption::AUTO;
        $oSyn = RunMethodOption::SYNCHRONOUS;
        $oAsy = RunMethodOption::ASYNC;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => 'Failed to solve RunMethodMode.',
                    ],
                ],
                [null, null, null],
            ],
            // [result], [$user, $detected, $default]
            [[$mS], [$oAut, $oSyn, $oAsy],],
            [[$mA], [$oAut, $oAsy, $oAsy],],
            [[$mS], [$oSyn, $oAsy, $oAsy],],
            [[$mA], [$oAsy, $oAsy, $oAsy],],
            [[$mA], [$oAsy, null, null],],
            [[$mS], [$oSyn, null, null],],
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

        $userAuxSettings = $this->getAuxSettingsMock($userRunMethodOption);
        $detectedAuxSettings = $this->getAuxSettingsMock($detectedRunMethodOption);
        $defaultAuxSettings = $this->getAuxSettingsMock($defaultRunMethodOption);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IAuxSettings::class))
            ->willReturn($userAuxSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IAuxSettings::class))
            ->willReturn($detectedAuxSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IAuxSettings::class))
            ->willReturn($defaultAuxSettings)
        ;

        $settingsProvider = $this->getSettingsProviderMock();

        $settingsProvider
            ->expects(self::once())
            ->method('getSettings')
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

    protected function getAuxSettingsMock(?RunMethodOption $runMethodOption = null): (MockObject&IAuxSettings)|null
    {
        return
            $runMethodOption === null
                ? null :
                $this->createConfiguredMock(
                    IAuxSettings::class,
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
