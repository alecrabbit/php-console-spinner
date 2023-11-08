<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StreamSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StreamSolverTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        $sOn = fopen('php://memory', 'rb+') and fclose($sOn);

        $sTw = STDOUT;
        $sTh = STDERR;

        yield from [
            // [Exception], [$user, $detected, $default]
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf('Unable to solve "%s".', 'stream'),
                    ],
                ],
                [null, null, null],
            ],
            // [result], [$user, $detected, $default]
            [[$sOn], [$sOn, null, null],], // #1
            [[$sOn], [null, $sOn, null],], // #2
            [[$sOn], [null, null, $sOn],], // #3
            [[$sTw], [$sTw, $sTh, $sOn],], // #4
            [[$sTh], [null, $sTh, $sOn],], // #5
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(StreamSolver::class, $solver);
    }

    protected function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
    ): IStreamSolver {
        return
            new StreamSolver(
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
            $userStream,
            $detectedStream,
            $defaultStream,
        ] = $args;

        $userOutputSettings = $this->getOutputSettingsMock($userStream);
        $detectedOutputSettings = $this->getOutputSettingsMock($detectedStream);
        $defaultOutputSettings = $this->getOutputSettingsMock($defaultStream);

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

        self::assertSame($result, $solver->solve());

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

    protected function getOutputSettingsMock(mixed $stream = null): (MockObject&IOutputSettings)|null
    {
        return
            $stream === null
                ? null :
                $this->createConfiguredMock(
                    IOutputSettings::class,
                    [
                        'getStream' => $stream,
                    ]
                );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
