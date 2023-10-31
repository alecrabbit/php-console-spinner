<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
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
            ->withCursorVisibilityMode(CursorVisibilityMode::VISIBLE)
            ->withStylingMethodMode(StylingMethodMode::ANSI4)
            ->withInitializationMode(InitializationMode::DISABLED)
            ->withStream(STDOUT)
            ->build()
        ;

        self::assertInstanceOf(OutputConfig::class, $config);
    }

    #[Test]
    public function withCursorVisibilityModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCursorVisibilityMode(CursorVisibilityMode::VISIBLE)
        ;

        self::assertInstanceOf(OutputConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withStylingMethodModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withStylingMethodMode(StylingMethodMode::ANSI4)
        ;

        self::assertInstanceOf(OutputConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfCursorVisibilityModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'CursorVisibilityMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylingMethodMode(StylingMethodMode::ANSI4)
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
    public function throwsIfStylingMethodModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'StylingMethodMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withCursorVisibilityMode(CursorVisibilityMode::VISIBLE)
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
                ->withStylingMethodMode(StylingMethodMode::ANSI4)
                ->withCursorVisibilityMode(CursorVisibilityMode::VISIBLE)
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
