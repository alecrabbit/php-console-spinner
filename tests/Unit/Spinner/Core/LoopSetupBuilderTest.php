<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Builder\LoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\LoopSetup;
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
        return new LoopSetupBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);

        $loopSetupBuilder = $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->withSettings($this->getLoopSettingsMock())
        ;

        self::assertInstanceOf(LoopSetup::class, $loopSetupBuilder->build());
    }

    #[Test]
    public function throwsIfLoopIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop is not set.';

        $test = function (): void {
            $loopSetupBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withSettings($this->getLoopSettingsMock())
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
            self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
            $loopSetupBuilder
                ->withLoop($this->getLoopMock())
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
