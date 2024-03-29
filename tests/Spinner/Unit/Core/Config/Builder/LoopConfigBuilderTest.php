<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Builder\LoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersContainer;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
            ->withSignalHandlingMode(SignalHandlingMode::DISABLED)
            ->withSignalHandlersContainer($this->getSignalHandlersContainerMock())
            ->build()
        ;

        self::assertInstanceOf(LoopConfig::class, $config);
    }

    private function getSignalHandlersContainerMock(): MockObject&ISignalHandlersContainer
    {
        return $this->createMock(ISignalHandlersContainer::class);
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
    public function withSignalHandlingModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withSignalHandlingMode(SignalHandlingMode::DISABLED)
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
                ->withSignalHandlingMode(SignalHandlingMode::DISABLED)
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
    public function throwsIfSignalHandlersContainerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Signal handlers container is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAutoStartMode(AutoStartMode::DISABLED)
                ->withSignalHandlingMode(SignalHandlingMode::DISABLED)
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
    public function throwsIfSignalHandlingModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'SignalHandlingMode is not set.';

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
