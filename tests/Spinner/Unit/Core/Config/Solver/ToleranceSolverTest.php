<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\Contract\IToleranceSolver;
use AlecRabbit\Spinner\Core\Config\Solver\ToleranceSolver;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Settings\Contract\IRevolverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ToleranceSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // [Exception], [$user, $detected, $default]
            // #0
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => LogicException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', ITolerance::class),
                    ],
                ],
                [null, null, null],
            ],
            // [result], [$user, $detected, $default]
            // #1
            [
                [
                    new Tolerance(
                        6,
                    ),
                ],
                [
                    null,
                    null,
                    new Tolerance(
                        6,
                    ),
                ],
            ],
            // #2
            [
                [
                    new Tolerance(
                        5,
                    ),
                ],
                [
                    null,
                    new Tolerance(
                        5,
                    ),
                    new Tolerance(
                        6,
                    ),
                ],
            ],
            // #3
            [
                [
                    new Tolerance(
                        4,
                    ),
                ],
                [
                    new Tolerance(
                        4,
                    ),
                    new Tolerance(
                        5,
                    ),
                    new Tolerance(
                        6,
                    ),
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(ToleranceSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IToleranceSolver {
        return
            new ToleranceSolver(
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
            $userTolerance,
            $detectedTolerance,
            $defaultTolerance
        ] = $args;

        $userDriverSettings = $this->getRevolverSettingsMock($userTolerance);
        $detectedDriverSettings = $this->getRevolverSettingsMock($detectedTolerance);
        $defaultDriverSettings = $this->getRevolverSettingsMock($defaultTolerance);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRevolverSettings::class))
            ->willReturn($userDriverSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRevolverSettings::class))
            ->willReturn($detectedDriverSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRevolverSettings::class))
            ->willReturn($defaultDriverSettings)
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

        $actual = $solver->solve();

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($result->toMilliseconds(), $actual->toMilliseconds());
    }

    protected function getRevolverSettingsMock(?ITolerance $tolerance = null): (MockObject&IRevolverSettings)|null
    {
        return
            $tolerance === null
                ? null :
                $this->createConfiguredMock(
                    IRevolverSettings::class,
                    [
                        'getTolerance' => $tolerance,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
