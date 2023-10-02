<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Builder\AuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IAuxConfigBuilder
    {
        return
            new AuxConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withRunMethodMode(RunMethodMode::SYNCHRONOUS)
            ->withNormalizerMethodMode(NormalizerMethodMode::STILL)
            ->build()
        ;

        self::assertInstanceOf(AuxConfig::class, $config);
    }

    #[Test]
    public function withRunMethodModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withRunMethodMode(RunMethodMode::SYNCHRONOUS)
        ;

        self::assertNotSame($builder, $configBuilder);
    }


    #[Test]
    public function withNormalizerMethodModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withNormalizerMethodMode(NormalizerMethodMode::STILL)
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfRunMethodModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'RunMethodMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withNormalizerMethodMode(NormalizerMethodMode::STILL)
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
    public function throwsIfNormalizerMethodModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'NormalizerMethodMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withRunMethodMode(RunMethodMode::SYNCHRONOUS)
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
