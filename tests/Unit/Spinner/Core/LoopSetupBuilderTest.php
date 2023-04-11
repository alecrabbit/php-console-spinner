<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\LoopSetupBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class LoopSetupBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
    }

    public function getTesteeInstance(): ILoopSetupBuilder
    {
        return
            new LoopSetupBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);

        $loopSetupBuilder = $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->withSettings($this->getLoopSettingsMock())
            ->withDriver($this->getDriverMock())
        ;

        self::assertInstanceOf(LoopSetup::class, $loopSetupBuilder->build());
    }

    #[Test]
    public function throwsIfLoopIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop is not set.';

        $test = function () {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withSettings($this->getLoopSettingsMock())
                ->withDriver($this->getDriverMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }

    #[Test]
    public function throwsIfLoopSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop settings are not set.';

        $test = function () {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoop($this->getLoopMock())
                ->withDriver($this->getDriverMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }

    #[Test]
    public function throwsIfDriverIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Driver is not set.';

        $test = function () {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoop($this->getLoopMock())
                ->withSettings($this->getLoopSettingsMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }
}
