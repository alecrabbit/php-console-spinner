<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class SignalHandlingModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mE = SignalHandlingMode::ENABLED;
        $mD = SignalHandlingMode::DISABLED;

        $oAu = SignalHandlingOption::AUTO;
        $oEn = SignalHandlingOption::ENABLED;
        $oDi = SignalHandlingOption::DISABLED;
        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlingMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlingMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlingMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', SignalHandlingMode::class),
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

            [[$mE], [$oAu, $oEn, $oEn],],

            [[$mE], [$oEn, $oEn, $oEn],],
            [[$mD], [$oDi, $oEn, $oEn],],

            [[$mD], [$oDi, $oEn, $oDi],],
            [[$mD], [$oDi, $oDi, $oEn],], // #28
            [[$mD], [$oAu, $oDi, $oEn],], // #29
            [[$mD], [$oEn, $oDi, $oEn],], // #30
            [[$mE], [$oAu, $oAu, $oEn],], // #31

            [[$mE], [$oEn, null, $oEn],], // #32
            [[$mD], [$oDi, null, $oEn],], // #33
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlingModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ISignalHandlingModeSolver {
        return
            new SignalHandlingModeSolver(
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
            $userSignalHandlingOption,
            $detectedSignalHandlingOption,
            $defaultSignalHandlingOption
        ] = $args;

        $userAuxSettings = $this->getLoopSettingsMock($userSignalHandlingOption);
        $detectedAuxSettings = $this->getLoopSettingsMock($detectedSignalHandlingOption);
        $defaultAuxSettings = $this->getLoopSettingsMock($defaultSignalHandlingOption);

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

    protected function getLoopSettingsMock(?SignalHandlingOption $autoStartOption = null
    ): (MockObject&ILoopSettings)|null {
        return
            $autoStartOption === null
                ? null :
                $this->createConfiguredMock(
                    ILoopSettings::class,
                    [
                        'getSignalHandlingOption' => $autoStartOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
