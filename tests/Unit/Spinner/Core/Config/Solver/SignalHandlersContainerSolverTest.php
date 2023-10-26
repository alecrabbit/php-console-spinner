<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerSettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SignalHandlersContainerSolverTest extends TestCase
{
    public static function canSolveDataProvider(): \Traversable
    {
        // fn() => [[result/Exception], [$user, $detected, $default]]
        // #0
        yield from [
            [
                static function (TestCase $_) {
                    return [[[]], [[], [], []]];
                }
            ]
        ];

        yield from [
            [self::dataSet001()],
            [self::dataSet002()],
            [self::dataSet003()],
            [self::dataSet004()],
            [self::dataSet005()],
            [self::dataSet006()],
            [self::dataSet007()],
            [self::dataSet008()],
            [self::dataSet009()],
            [self::dataSet010()],
            [self::dataSet011()],
        ];
    }

    protected static function dataSet001(): \Closure
    {
        return
            static function (self $test) {
                $signal = 2;
                $handlerCreator = $test->getHandlerCreatorMock();

                $signalHandlerCreator = $test->getSignalHandlerCreatorMock();
                $signalHandlerCreator
                    ->expects(self::once())
                    ->method('getSignal')
                    ->willReturn($signal)
                ;
                $signalHandlerCreator
                    ->expects(self::once())
                    ->method('getHandlerCreator')
                    ->willReturn($handlerCreator)
                ;
                // [result], [$user, $detected, $default]
                return [
                    [
                        [
                            $signal => $handlerCreator,
                        ]
                    ],

                    [
                        [],
                        [
                            $signalHandlerCreator,
                        ],
                        []
                    ],
                ];
            };
    }

    private function getHandlerCreatorMock(): MockObject&IHandlerCreator
    {
        return $this->createMock(IHandlerCreator::class);
    }

    private function getSignalHandlerCreatorMock(): MockObject&ISignalHandlerCreator
    {
        return $this->createMock(ISignalHandlerCreator::class);
    }

    protected static function dataSet002(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $handlerCreator = $test->getHandlerCreatorMock();

            $signalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $signalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $signalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($handlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $handlerCreator,
                    ],
                ],

                [
                    [
                        $signalHandlerCreator,
                    ],
                    [],
                    [],
                ],
            ];
        };
    }

    protected static function dataSet003(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $handlerCreator = $test->getHandlerCreatorMock();

            $signalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $signalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $signalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($handlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $handlerCreator,
                    ]
                ],

                [
                    [],
                    [],
                    [
                        $signalHandlerCreator,
                    ],
                ],
            ];
        };
    }

    protected static function dataSet004(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $detectedHandlerCreator = $test->getHandlerCreatorMock();
            $userHandlerCreator = $test->getHandlerCreatorMock();

            $detectedSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($detectedHandlerCreator)
            ;
            $userSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($userHandlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $userHandlerCreator,
                    ]
                ],

                [
                    [
                        $userSignalHandlerCreator,
                    ],
                    [
                        $detectedSignalHandlerCreator,
                    ],
                    [],
                ],
            ];
        };
    }

    protected static function dataSet005(): \Closure
    {
        return static function (self $test) {
            // [Exception], [$user, $detected, $default]
            $value = [];

            $message =
                sprintf(
                    'Creator must be instance of "%s", "%s" given.',
                    ISignalHandlerCreator::class,
                    get_debug_type($value)
                );
            return [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => $message,
                    ],
                ],
                [[], [$value], []]
            ];
        };
    }

    protected static function dataSet006(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $defaultHandlerCreator = $test->getHandlerCreatorMock();
            $detectedHandlerCreator = $test->getHandlerCreatorMock();
            $userHandlerCreator = $test->getHandlerCreatorMock();

            $detectedSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($detectedHandlerCreator)
            ;

            $defaultSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($defaultHandlerCreator)
            ;

            $userSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($userHandlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $userHandlerCreator,
                    ]
                ],

                [
                    [
                        $userSignalHandlerCreator,
                    ],
                    [
                        $detectedSignalHandlerCreator,
                    ],
                    [
                        $defaultSignalHandlerCreator,
                    ],
                ],
            ];
        };
    }
    protected static function dataSet010(): \Closure
    {
        return static function (self $test) {
            $sigint = 2;
            $sigkill = 9;

            $sigIntHandlerCreator = $test->getHandlerCreatorMock();
            $sigKillHandlerCreator = $test->getHandlerCreatorMock();

            $sigIntSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $sigIntSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($sigint)
            ;
            $sigIntSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($sigIntHandlerCreator)
            ;

            $sigKillSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $sigKillSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($sigkill)
            ;
            $sigKillSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($sigKillHandlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $sigint => $sigIntHandlerCreator,
                        $sigkill => $sigKillHandlerCreator,
                    ]
                ],

                [
                    [
                        $sigKillSignalHandlerCreator,
                    ],
                    [
                        $sigIntSignalHandlerCreator,
                    ],
                    [
                    ],
                ],
            ];
        };
    }
    protected static function dataSet011(): \Closure
    {
        return static function (self $test) {
            $sigint = 2;
            $sigkill = 9;

            $sigIntHandlerCreatorUser = $test->getHandlerCreatorMock();
            $sigIntHandlerCreatorDetected = $test->getHandlerCreatorMock();
            $sigKillHandlerCreator = $test->getHandlerCreatorMock();

            $sigIntSignalHandlerCreatorDetected = $test->getSignalHandlerCreatorMock();
            $sigIntSignalHandlerCreatorDetected
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($sigint)
            ;
            $sigIntSignalHandlerCreatorDetected
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($sigIntHandlerCreatorDetected)
            ;
            $sigIntSignalHandlerCreatorUser = $test->getSignalHandlerCreatorMock();
            $sigIntSignalHandlerCreatorUser
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($sigint)
            ;
            $sigIntSignalHandlerCreatorUser
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($sigIntHandlerCreatorUser)
            ;

            $sigKillSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $sigKillSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($sigkill)
            ;
            $sigKillSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($sigKillHandlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $sigint => $sigIntHandlerCreatorUser,
                        $sigkill => $sigKillHandlerCreator,
                    ]
                ],

                [
                    [
                        $sigKillSignalHandlerCreator,
                        $sigIntSignalHandlerCreatorUser,
                    ],
                    [
                        $sigIntSignalHandlerCreatorDetected,
                    ],
                    [
                    ],
                ],
            ];
        };
    }

    protected static function dataSet007(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $defaultHandlerCreator = $test->getHandlerCreatorMock();
            $userHandlerCreator = $test->getHandlerCreatorMock();

            $defaultSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($defaultHandlerCreator)
            ;

            $userSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $userSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($userHandlerCreator)
            ;
            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $userHandlerCreator,
                    ]
                ],

                [
                    [
                        $userSignalHandlerCreator,
                    ],
                    [
                    ],
                    [
                        $defaultSignalHandlerCreator,
                    ],
                ],
            ];
        };
    }

    protected static function dataSet008(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $defaultHandlerCreator = $test->getHandlerCreatorMock();
            $detectedHandlerCreator = $test->getHandlerCreatorMock();

            $detectedSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $detectedSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($detectedHandlerCreator)
            ;

            $defaultSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($defaultHandlerCreator)
            ;

            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $detectedHandlerCreator,
                    ]
                ],

                [
                    [
                    ],
                    [
                        $detectedSignalHandlerCreator,
                    ],
                    [
                        $defaultSignalHandlerCreator,
                    ],
                ],
            ];
        };
    }

    protected static function dataSet009(): \Closure
    {
        return static function (self $test) {
            $signal = 2;
            $defaultHandlerCreator = $test->getHandlerCreatorMock();

            $defaultSignalHandlerCreator = $test->getSignalHandlerCreatorMock();
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getSignal')
                ->willReturn($signal)
            ;
            $defaultSignalHandlerCreator
                ->expects(self::once())
                ->method('getHandlerCreator')
                ->willReturn($defaultHandlerCreator)
            ;

            // [result], [$user, $detected, $default]
            return [
                [
                    [
                        $signal => $defaultHandlerCreator,
                    ]
                ],

                [
                    [],
                    [],
                    [
                        $defaultSignalHandlerCreator,
                    ],
                ],
            ];
        };
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersContainerSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): ISignalHandlersContainerSolver {
        return
            new SignalHandlersContainerSolver(
                settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
            );
    }

    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    #[Test]
    #[DataProvider('canSolveDataProvider')]
    public function canSolve(callable $data): void
    {
        [
            $expected,
            $args,
        ] = $data($this);

        $expectedException = $this->expectsException($expected);

        $result = $expected[0] ?? $expectedException;

        [
            $user,
            $detected,
            $default
        ] = $args;

        $userCreators = new \ArrayObject($user);
        $detectedCreators = new \ArrayObject($detected);
        $defaultCreators = new \ArrayObject($default);

        $userSignalHandlerSettings = $this->getSignalHandlerSettingsMock();
        $userSignalHandlerSettings
            ->expects(self::once())
            ->method('getCreators')
            ->willReturn($userCreators)
        ;
        $detectedSignalHandlerSettings = $this->getSignalHandlerSettingsMock();
        $detectedSignalHandlerSettings
            ->expects(self::once())
            ->method('getCreators')
            ->willReturn($detectedCreators)
        ;
        $defaultSignalHandlerSettings = $this->getSignalHandlerSettingsMock();
        $defaultSignalHandlerSettings
            ->expects(self::once())
            ->method('getCreators')
            ->willReturn($defaultCreators)
        ;

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(ISignalHandlerSettings::class)
            ->willReturn($userSignalHandlerSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(ISignalHandlerSettings::class)
            ->willReturn($detectedSignalHandlerSettings)
        ;
        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(ISignalHandlerSettings::class)
            ->willReturn($defaultSignalHandlerSettings)
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

        $container = $solver->solve();

        self::assertEquals($result, iterator_to_array($container->getSignalHandlers()));

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    private function getSignalHandlerSettingsMock(): MockObject&ISignalHandlerSettings
    {
        return $this->createMock(ISignalHandlerSettings::class);
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
