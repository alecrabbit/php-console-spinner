<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\DriverMessagesSolver;
use AlecRabbit\Spinner\Core\DriverMessages;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverMessagesSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // [result], [$user, $detected, $default]
            [ // #0
                [
                    new DriverMessages(
                        '',
                        '',
                    ),
                ],
                [
                    new Messages(),
                    new Messages(),
                    new Messages(),
                ],
            ],
            [ // #1
                [
                    new DriverMessages(
                        '',
                        '',
                    ),
                ],
                [
                    null,
                    null,
                    null,
                ],
            ],
            [ // #2
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    new Messages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                    null,
                    null,
                ],
            ],
            [ // #3
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    null,
                    new Messages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                    null,
                ],
            ],
            [ // #4
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    null,
                    null,
                    new Messages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
            ],
            [ // #5
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    new Messages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                    null,
                    new Messages(
                        finalMessage: 'final0',
                        interruptionMessage: 'interruption0',
                    ),
                ],
            ],
            [ // #6
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    new Messages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                    new Messages(
                        finalMessage: 'final1',
                        interruptionMessage: 'interruption1',
                    ),
                    new Messages(
                        finalMessage: 'final0',
                        interruptionMessage: 'interruption0',
                    ),
                ],
            ],
            [ // #7
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: '',
                    ),
                ],
                [
                    new Messages(
                        finalMessage: 'final',
                    ),
                    new Messages(
                        finalMessage: 'final1',
                    ),
                    new Messages(
                        finalMessage: 'final0',
                    ),
                ],
            ],
            [ // #8
                [
                    new DriverMessages(
                        finalMessage: '',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    new Messages(
                        interruptionMessage: 'interruption',
                    ),
                    new Messages(
                        interruptionMessage: 'interruption1',
                    ),
                    new Messages(
                        interruptionMessage: 'interruption0',
                    ),
                ],
            ],
            [ // #9
                [
                    new DriverMessages(
                        finalMessage: 'final',
                        interruptionMessage: 'interruption',
                    ),
                ],
                [
                    new Messages(
                        interruptionMessage: 'interruption',
                    ),
                    new Messages(
                        finalMessage: 'final',
                    ),
                    null
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(DriverMessagesSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IDriverMessagesSolver {
        return
            new DriverMessagesSolver(
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
            $userMessages,
            $detectedMessages,
            $defaultMessages
        ] = $args;

        $userDriverSettings = $this->getDriverSettingsMock($userMessages);
        $detectedDriverSettings = $this->getDriverSettingsMock($detectedMessages);
        $defaultDriverSettings = $this->getDriverSettingsMock($defaultMessages);

        $userSettings = $this->getSettingsMock();
        $userSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IDriverSettings::class))
            ->willReturn($userDriverSettings)
        ;

        $detectedSettings = $this->getSettingsMock();
        $detectedSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IDriverSettings::class))
            ->willReturn($detectedDriverSettings)
        ;

        $defaultSettings = $this->getSettingsMock();
        $defaultSettings
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IDriverSettings::class))
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

        self::assertSame($result->getFinalMessage(), $actual->getFinalMessage());
        self::assertSame($result->getInterruptionMessage(), $actual->getInterruptionMessage());

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    protected function getDriverSettingsMock(?IMessages $messages = null): (MockObject&IDriverSettings)|null
    {
        return
            $messages === null
                ? null :
                $this->createConfiguredMock(
                    IDriverSettings::class,
                    [
                        'getMessages' => $messages,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
