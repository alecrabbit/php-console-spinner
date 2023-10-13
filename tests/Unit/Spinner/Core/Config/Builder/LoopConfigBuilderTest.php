<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Core\Config\Builder\LoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LoopConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): ILoopConfigBuilder
    {
        return
            new LoopConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withAutoStartMode(AutoStartMode::DISABLED)
            ->withSignalHandlersMode(SignalHandlersMode::DISABLED)
            ->build()
        ;

        self::assertInstanceOf(LoopConfig::class, $config);
    }

    #[Test]
    public function withAutoStartModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withAutoStartMode(AutoStartMode::DISABLED)
        ;

        self::assertInstanceOf(LoopConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withSignalHandlersModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withSignalHandlersMode(SignalHandlersMode::DISABLED)
        ;

        self::assertInstanceOf(LoopConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfAutoStartModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'AutoStartMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withSignalHandlersMode(SignalHandlersMode::DISABLED)
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
    public function throwsIfSignalHandlersModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'SignalHandlersMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAutoStartMode(AutoStartMode::DISABLED)
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