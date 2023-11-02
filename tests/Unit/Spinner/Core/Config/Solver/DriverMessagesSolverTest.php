<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\DriverMessagesSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

use function sprintf;

final class DriverMessagesSolverTest extends TestCase
{
   
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
//
//    #[Test]
//    #[DataProvider('canSolveDataProvider')]
//    public function canSolve(array $expected, array $args): void
//    {
//        $expectedException = $this->expectsException($expected);
//
//        $result = $expected[0] ?? null;
//
//        [
//            $userLinkerOption,
//            $detectedLinkerOption,
//            $defaultLinkerOption
//        ] = $args;
//
//        $userLinkerSettings = $this->getLinkerSettingsMock($userLinkerOption);
//        $detectedLinkerSettings = $this->getLinkerSettingsMock($detectedLinkerOption);
//        $defaultLinkerSettings = $this->getLinkerSettingsMock($defaultLinkerOption);
//
//        $userSettings = $this->getSettingsMock();
//        $userSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(ILinkerSettings::class))
//            ->willReturn($userLinkerSettings)
//        ;
//
//        $detectedSettings = $this->getSettingsMock();
//        $detectedSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(ILinkerSettings::class))
//            ->willReturn($detectedLinkerSettings)
//        ;
//
//        $defaultSettings = $this->getSettingsMock();
//        $defaultSettings
//            ->expects(self::once())
//            ->method('get')
//            ->with(self::identicalTo(ILinkerSettings::class))
//            ->willReturn($defaultLinkerSettings)
//        ;
//
//        $settingsProvider = $this->getSettingsProviderMock();
//
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getUserSettings')
//            ->willReturn($userSettings)
//        ;
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getDetectedSettings')
//            ->willReturn($detectedSettings)
//        ;
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getDefaultSettings')
//            ->willReturn($defaultSettings)
//        ;
//
//        $solver = $this->getTesteeInstance(
//            settingsProvider: $settingsProvider,
//        );
//
//        self::assertSame($result, $solver->solve());
//
//        if ($expectedException) {
//            self::failTest($expectedException);
//        }
//    }

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
