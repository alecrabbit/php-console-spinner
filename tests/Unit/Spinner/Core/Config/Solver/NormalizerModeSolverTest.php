<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\NormalizerModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class NormalizerModeSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $mSm = NormalizerMode::SMOOTH;
        $mBa = NormalizerMode::BALANCED;
        $mPe = NormalizerMode::PERFORMANCE;
        $mSl = NormalizerMode::SLOW;
        $mSt = NormalizerMode::STILL;

        $oAu = NormalizerOption::AUTO;
        $oSm = NormalizerOption::SMOOTH;
        $oBa = NormalizerOption::BALANCED;
        $oPe = NormalizerOption::PERFORMANCE;
        $oSl = NormalizerOption::SLOW;
        $oSt = NormalizerOption::STILL;


        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [$oAu, null, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oAu, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, null, $oAu],
            ],
            // [result], [$user, $detected, $default]
            [[$mSm], [$oAu, null, $oSm],], // #4
            [[$mBa], [$oAu, null, $oBa],], // #5
            [[$mPe], [$oAu, null, $oPe],], // #6
            [[$mSl], [$oAu, null, $oSl],], // #7
            [[$mSt], [$oAu, null, $oSt],], // #8
            [[$mSm], [$oSm, null, null],], // #9
            [[$mBa], [$oBa, null, null],], // #10
            [[$mPe], [$oPe, null, null],], // #11
            [[$mSl], [$oSl, null, null],], // #12
            [[$mSt], [$oSt, null, null],], // #13
            [[$mSm], [null, null, $oSm],], // #14
            [[$mBa], [null, null, $oBa],], // #15
            [[$mPe], [null, null, $oPe],], // #16
            [[$mSl], [null, null, $oSl],], // #17
            [[$mSt], [null, null, $oSt],], // #18
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oSm, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oBa, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oPe, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oSl, null],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', NormalizerMode::class),
                    ],
                ],
                [null, $oSt, null],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(NormalizerModeSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): INormalizerModeSolver {
        return
            new NormalizerModeSolver(
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
            $userNormalizerOption,
            $detectedNormalizerOption,
            $defaultNormalizerOption
        ] = $args;

        $userAuxSettings = $this->getAuxSettingsMock($userNormalizerOption);
        $detectedAuxSettings = $this->getAuxSettingsMock($detectedNormalizerOption);
        $defaultAuxSettings = $this->getAuxSettingsMock($defaultNormalizerOption);

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

    protected function getAuxSettingsMock(?NormalizerOption $normalizerOption = null): (MockObject&IAuxSettings)|null
    {
        return
            $normalizerOption === null
                ? null :
                $this->createConfiguredMock(
                    IAuxSettings::class,
                    [
                        'getNormalizerOption' => $normalizerOption,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}