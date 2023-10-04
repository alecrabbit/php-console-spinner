<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
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
        $o4b = StylingMethodOption::ANSI4;
        $o8b = StylingMethodOption::ANSI8;
        $o24 = StylingMethodOption::ANSI24;


        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', StylingMethodMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
//            [[$mNo], [$oAu, null, $o4b],], // #4
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

    protected function getOutputSettingsMock(?StylingMethodOption $normalizerOption = null): (MockObject&IOutputSettings)|null
    {
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
