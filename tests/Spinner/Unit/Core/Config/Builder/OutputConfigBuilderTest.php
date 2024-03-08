<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Config\Builder\OutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\OutputConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class OutputConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(OutputConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IOutputConfigBuilder
    {
        return
            new OutputConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withCursorMode(CursorMode::VISIBLE)
            ->withStylingMode(StylingMode::ANSI4)
            ->withInitializationMode(InitializationMode::DISABLED)
            ->withStream(STDOUT)
            ->build()
        ;

        self::assertInstanceOf(OutputConfig::class, $config);
    }

    #[Test]
    public function withCursorModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCursorMode(CursorMode::VISIBLE)
        ;

        self::assertInstanceOf(OutputConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withStylingModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withStylingMode(StylingMode::ANSI4)
        ;

        self::assertInstanceOf(OutputConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfCursorModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'CursorMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylingMode(StylingMode::ANSI4)
                ->withInitializationMode(InitializationMode::DISABLED)
                ->withStream(STDOUT)
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
    public function throwsIfStylingModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'StylingMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withCursorMode(CursorMode::VISIBLE)
                ->withInitializationMode(InitializationMode::DISABLED)
                ->withStream(STDOUT)
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
    public function throwsIfInitializationModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'InitializationMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylingMode(StylingMode::ANSI4)
                ->withCursorMode(CursorMode::VISIBLE)
                ->withStream(STDOUT)
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
