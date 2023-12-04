<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\LinkerModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class LinkerModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mE = LinkerMode::ENABLED;
        $mD = LinkerMode::DISABLED;

        $oAu = LinkerOption::AUTO;
        $oEn = LinkerOption::ENABLED;
        $oDi = LinkerOption::DISABLED;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', LinkerMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', LinkerMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', LinkerMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', LinkerMode::class),
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

            [[$mD], [$oDi, $oEn, $oEn],], // #25
            [[$mE], [$oEn, $oEn, $oEn],], // #26

            [[$mE], [$oEn, null, $oEn],], // #27
            [[$mD], [$oDi, null, $oEn],], // #28
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ILinkerModeSolver {
        return
            new LinkerModeSolver(
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
            $userLinkerOption,
            $detectedLinkerOption,
            $defaultLinkerOption
        ] = $args;

        $userLinkerSettings = $this->getLinkerSettingsMock($userLinkerOption);
        $detectedLinkerSettings = $this->getLinkerSettingsMock($detectedLinkerOption);
        $defaultLinkerSettings = $this->getLinkerSettingsMock($defaultLinkerOption);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILinkerSettings::class))
            ->willReturn($userLinkerSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILinkerSettings::class))
            ->willReturn($detectedLinkerSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(ILinkerSettings::class))
            ->willReturn($defaultLinkerSettings)
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

    protected function getLinkerSettingsMock(?LinkerOption $linkerOption = null): (MockObject&ILinkerSettings)|null
    {
        return
            $linkerOption === null
                ? null :
                $this->createConfiguredMock(
                    ILinkerSettings::class,
                    [
                        'getLinkerOption' => $linkerOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
