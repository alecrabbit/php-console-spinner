<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class StylingMethodModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mNo = StylingMethodMode::NONE;
        $m4b = StylingMethodMode::ANSI4;
        $m8b = StylingMethodMode::ANSI8;
        $m24 = StylingMethodMode::ANSI24;

        $oAu = StylingMethodOption::AUTO;
        $oNo = StylingMethodOption::NONE;
        $o4b = StylingMethodOption::ANSI4;
        $o8b = StylingMethodOption::ANSI8;
        $o24 = StylingMethodOption::ANSI24;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
            [[$mNo], [$oAu, null, $oNo],], // #4
            [[$mNo], [$oAu, $oNo, $o4b],], // #5
            [[$mNo], [$oAu, $oNo, $o8b],], // #6
            [[$mNo], [$oAu, $oNo, $o24],], // #7
            [[$mNo], [$oAu, $oNo, $oNo],], // #8
            [[$mNo], [null, $oNo, $oNo],], // #9
            [[$mNo], [null, $oNo, $o4b],], // #10
            [[$mNo], [null, $oNo, $o8b],], // #11
            [[$mNo], [null, $oNo, $o24],], // #12
            [[$mNo], [null, $oNo, $oNo],], // #13
            [[$mNo], [$oNo, $oNo, $oNo],], // #14
            [[$mNo], [$oNo, $oNo, $o4b],], // #15
            [[$mNo], [$oNo, $oNo, $o8b],], // #16
            [[$mNo], [$oNo, $oNo, $o24],], // #17
            [[$mNo], [$oNo, $oNo, null],], // #18
            [[$mNo], [$oAu, $oNo, null],], // #19
            [[$mNo], [$oNo, $oNo, null],], // #20
            [[$mNo], [$o4b, $oNo, null],], // #21
            [[$mNo], [$o8b, $oNo, null],], // #22
            [[$mNo], [$o24, $oNo, null],], // #23

            [[$m4b], [$oAu, $o4b, null],], // #24
            [[$m4b], [$o4b, $o4b, $o4b],], // #25
            [[$m4b], [$o8b, $o4b, $o8b],], // #26
            [[$m4b], [$o24, $o4b, $o24],], // #27

            [[$m8b], [$oAu, $o8b, null],], // #28
            [[$m4b], [$o4b, $o8b, $o4b],], // #29
            [[$m8b], [$o8b, $o8b, $o8b],], // #30
            [[$m8b], [$o24, $o8b, $o24],], // #31

            [[$m24], [$oAu, $o24, null],], // #32
            [[$m4b], [$o4b, $o24, $o4b],], // #33
            [[$m8b], [$o8b, $o24, $o8b],], // #34
            [[$m24], [$o24, $o24, $o24],], // #35

            [[$m24], [$o24, null, null],], // #36
            [[$m24], [null, null, $o24],], // #37
            [[$m24], [$oAu, null, $o24],], // #38

            [[$m4b], [$o4b, null, null],], // #39
            [[$m4b], [null, null, $o4b],], // #40

            [[$m8b], [$o8b, null, null],], // #41
            [[$m8b], [null, null, $o8b],], // #42
            [[$m8b], [null, $oAu, $o8b],], // #43
            [[$m4b], [null, $oAu, $o4b],], // #44
            [[$mNo], [null, $oAu, $oNo],], // #45
            [[$mNo], [$oNo, $oAu, $o24],], // #46
            [[$mNo], [$oNo, $o4b, $o24],], // #48
            [[$mNo], [$oNo, $o8b, $o24],], // #49
            [[$mNo], [$oNo, $o24, $o24],], // #50

            [[$m4b], [$o4b, $o24, $o24],], // #51
            [[$m4b], [$o4b, $o8b, $o24],], // #52
            [[$m4b], [$o4b, $o4b, $o24],], // #53
            [[$m4b], [$o4b, $oAu, $oAu],], // #54
            [[$m4b], [null, null, $o4b],], // #55
            [[$m4b], [null, $o4b, null],], // #56
            [[$m8b], [null, $o8b, null],], // #57
            [[$m24], [null, $o24, null],], // #58
            [[$mNo], [null, $oNo, null],], // #59

            [[$mNo], [$oNo, $oAu, $oAu],], // #60
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(StylingMethodModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IStylingMethodModeSolver {
        return
            new StylingMethodModeSolver(
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
            $userStylingMethodOption,
            $detectedStylingMethodOption,
            $defaultStylingMethodOption
        ] = $args;

        $userOutputSettings = $this->getOutputSettingsMock($userStylingMethodOption);
        $detectedOutputSettings = $this->getOutputSettingsMock($detectedStylingMethodOption);
        $defaultOutputSettings = $this->getOutputSettingsMock($defaultStylingMethodOption);

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

        self::assertEquals($result, $solver->solve());

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    protected function getOutputSettingsMock(?StylingMethodOption $normalizerOption = null
    ): (MockObject&IOutputSettings)|null {
        return
            $normalizerOption === null
                ? null :
                $this->createConfiguredMock(
                    IOutputSettings::class,
                    [
                        'getStylingMethodOption' => $normalizerOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
