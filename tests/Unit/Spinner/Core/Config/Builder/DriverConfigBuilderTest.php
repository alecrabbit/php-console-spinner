<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Builder\DriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DriverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IDriverConfigBuilder
    {
        return
            new DriverConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withLinkerMode(LinkerMode::DISABLED)
            ->build()
        ;

        self::assertInstanceOf(DriverConfig::class, $config);
    }

    #[Test]
    public function withLinkerModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withLinkerMode(LinkerMode::DISABLED)
        ;

        self::assertInstanceOf(DriverConfigBuilder::class, $builder);
        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfLinkerModeModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'LinkerMode is not set.';

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
