<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Config\Builder\NormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\INormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\NormalizerConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NormalizerConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(NormalizerConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): INormalizerConfigBuilder
    {
        return
            new NormalizerConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withNormalizerMode(NormalizerMode::STILL)
            ->build()
        ;

        self::assertInstanceOf(NormalizerConfig::class, $config);
    }

    #[Test]
    public function withNormalizerModeReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withNormalizerMode(NormalizerMode::STILL)
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfNormalizerModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'NormalizerMode is not set.';

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
