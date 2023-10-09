<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlersModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class SignalHandlersModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mE = SignalHandlersMode::ENABLED;
        $mD = SignalHandlersMode::DISABLED;

        $oAu = SignalHandlersOption::AUTO;
        $oEn = SignalHandlersOption::ENABLED;
        $oDi = SignalHandlersOption::DISABLED;
        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlersMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlersMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlersMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlersMode::class),
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

            [[$mE], [$oAu, null, $oEn],],
            [[$mD], [$oAu, null, $oDi],],

            [[$mE], [null, $oAu, $oEn],],
            [[$mD], [null, $oAu, $oDi],],

            [[$mE], [null, $oEn, $oEn],],
            [[$mD], [null, $oDi, $oDi],],

            [[$mD], [null, $oDi, $oEn],],
            [[$mD], [null, $oEn, $oDi],],

            [[$mE], [null, null, $oEn],],
            [[$mD], [null, null, $oDi],],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ISignalHandlersModeSolver {
        return
            new SignalHandlersModeSolver(
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
            $userSignalHandlersOption,
            $detectedSignalHandlersOption,
            $defaultSignalHandlersOption
        ] = $args;

        $userAuxSettings = $this->getLoopSettingsMock($userSignalHandlersOption);
        $detectedAuxSettings = $this->getLoopSettingsMock($detectedSignalHandlersOption);
        $defaultAuxSettings = $this->getLoopSettingsMock($defaultSignalHandlersOption);

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

    protected function getLoopSettingsMock(?SignalHandlersOption $autoStartOption = null
    ): (MockObject&ILoopSettings)|null {
        return
            $autoStartOption === null
                ? null :
                $this->createConfiguredMock(
                    ILoopSettings::class,
                    [
                        'getSignalHandlersOption' => $autoStartOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
