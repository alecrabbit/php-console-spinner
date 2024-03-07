<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Builder\GeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\GeneralConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GeneralConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(GeneralConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IGeneralConfigBuilder
    {
        return
            new GeneralConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withExecutionMode(ExecutionMode::SYNCHRONOUS)
            ->build()
        ;

        self::assertInstanceOf(GeneralConfig::class, $config);
    }

    #[Test]
    public function withExecutionModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withExecutionMode(ExecutionMode::SYNCHRONOUS)
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfExecutionModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'ExecutionMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
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
