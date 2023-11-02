<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Builder\LinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\LinkerConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LinkerConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): ILinkerConfigBuilder
    {
        return
            new LinkerConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withLinkerMode(LinkerMode::DISABLED)
            ->build()
        ;

        self::assertInstanceOf(LinkerConfig::class, $config);
    }

    #[Test]
    public function withLinkerModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withLinkerMode(LinkerMode::DISABLED)
        ;

        self::assertInstanceOf(LinkerConfigBuilder::class, $builder);
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
