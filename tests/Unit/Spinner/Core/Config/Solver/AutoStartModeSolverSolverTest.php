<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\AutoStartModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class AutoStartModeSolverSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mE = AutoStartMode::ENABLED;
        $mD = AutoStartMode::DISABLED;

        $oAu = AutoStartOption::AUTO;
        $oEn = AutoStartOption::ENABLED;
        $oDi = AutoStartOption::DISABLED;
        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', AutoStartMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', AutoStartMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', AutoStartMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', AutoStartMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
            [[$mE], [$oAu, $oEn, $oDi],],
            [[$mD], [$oAu, $oDi, $oDi],],

            [[$mE], [$oEn, $oDi, $oDi],],
            [[$mD], [$oDi, $oDi, $oDi],],

            [[$mE], [$oEn, null, null],],
            [[$mD], [$oDi, null, null],],

            [[$mE], [$oAu, $oEn, null],],
            [[$mD], [$oAu, $oDi, null],],

            [[$mE], [null, $oEn, null],],
            [[$mD], [null, $oDi, null],],

//            [[$mE], [$oAu, null, $oEn],],
//            [[$mD], [$oAu, null, $oDi],],
//
//            [[$mE], [null, $oAu, $oEn],],
//            [[$mD], [null, $oAu, $oDi],],
//
//            [[$mE], [null, null, $oEn],],
//            [[$mD], [null, null, $oDi],],

        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(AutoStartModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IAutoStartModeSolver {
        return
            new AutoStartModeSolver(
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
            $userAutoStartOption,
            $detectedAutoStartOption,
            $defaultAutoStartOption
        ] = $args;

        $userAuxSettings = $this->getLoopSettingsMock($userAutoStartOption);
        $detectedAuxSettings = $this->getLoopSettingsMock($detectedAutoStartOption);
        $defaultAuxSettings = $this->getLoopSettingsMock($defaultAutoStartOption);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILoopSettings::class))
            ->willReturn($userAuxSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILoopSettings::class))
            ->willReturn($detectedAuxSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILoopSettings::class))
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

    protected function getLoopSettingsMock(?AutoStartOption $autoStartOption = null): (MockObject&ILoopSettings)|null
    {
        return
            $autoStartOption === null
                ? null :
                $this->createConfiguredMock(
                    ILoopSettings::class,
                    [
                        'getAutoStartOption' => $autoStartOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
