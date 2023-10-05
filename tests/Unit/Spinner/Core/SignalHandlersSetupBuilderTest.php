<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\SignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\SignalHandlersSetup;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersSetupBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersSetupBuilder::class, $loopSetupBuilder);
    }

    public function getTesteeInstance(): ISignalHandlersSetupBuilder
    {
        return new SignalHandlersSetupBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersSetupBuilder::class, $loopSetupBuilder);

        $loopSetupBuilder = $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->withLoopSettings($this->getLegacyLoopSettingsMock())
            ->withDriverSettings($this->getLegacyDriverSettingsMock())
        ;

        self::assertInstanceOf(SignalHandlersSetup::class, $loopSetupBuilder->build());
    }

    #[Test]
    public function throwsIfLoopIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop is not set.';

        $test = function (): void {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(SignalHandlersSetupBuilder::class, $loopSetupBuilder);
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
            self::assertInstanceOf(SignalHandlersSetupBuilder::class, $loopSetupBuilder);
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
            self::assertInstanceOf(SignalHandlersSetupBuilder::class, $loopSetupBuilder);
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
