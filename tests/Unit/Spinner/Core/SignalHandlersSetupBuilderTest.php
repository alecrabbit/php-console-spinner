<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Legacy\ILegacySignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Legacy\LegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Legacy\LegacySignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersSetupBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalHandlersSetupBuilder::class, $loopSetupBuilder);
    }

    public function getTesteeInstance(): ILegacySignalHandlersSetupBuilder
    {
        return new LegacySignalHandlersSetupBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalHandlersSetupBuilder::class, $loopSetupBuilder);

        $loopSetupBuilder = $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->withLoopSettings($this->getLegacyLoopSettingsMock())
            ->withDriverSettings($this->getLegacyDriverSettingsMock())
        ;

        self::assertInstanceOf(LegacySignalHandlersSetup::class, $loopSetupBuilder->build());
    }

    #[Test]
    public function throwsIfLoopIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop is not set.';

        $test = function (): void {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LegacySignalHandlersSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoopSettings($this->getLegacyLoopSettingsMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfLoopSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop settings are not set.';

        $test = function (): void {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LegacySignalHandlersSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoop($this->getLoopMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfDriverSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Driver settings are not set.';

        $test = function (): void {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LegacySignalHandlersSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoop($this->getLoopMock())
                ->withLoopSettings($this->getLegacyLoopSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
