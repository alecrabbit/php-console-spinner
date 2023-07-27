<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Builder\Config;

use AlecRabbit\Spinner\Core\Builder\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Builder\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IConfigBuilder
    {
        return
            new ConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withAuxConfig($this->getAuxConfigMock())
            ->withLoopConfig($this->getLoopConfigMock())
            ->withOutputConfig($this->getOutputConfigMock())
            ->withDriverConfig($this->getDriverConfigMock())
            ->withWidgetConfig($this->getWidgetConfigMock())
            ->withRootWidgetConfig($this->getWidgetConfigMock())
            ->build()
        ;

        self::assertInstanceOf(Config::class, $config);
    }

    protected function getAuxConfigMock(): MockObject&IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

    protected function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    protected function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function throwsIfAuxConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'AuxConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withLoopConfig($this->getLoopConfigMock())
                ->withOutputConfig($this->getOutputConfigMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->withWidgetConfig($this->getWidgetConfigMock())
                ->withRootWidgetConfig($this->getWidgetConfigMock())
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
    public function throwsIfLoopConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'LoopConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAuxConfig($this->getAuxConfigMock())
                ->withOutputConfig($this->getOutputConfigMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->withWidgetConfig($this->getWidgetConfigMock())
                ->withRootWidgetConfig($this->getWidgetConfigMock())
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
    public function throesIfOutputConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'OutputConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAuxConfig($this->getAuxConfigMock())
                ->withLoopConfig($this->getLoopConfigMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->withWidgetConfig($this->getWidgetConfigMock())
                ->withRootWidgetConfig($this->getWidgetConfigMock())
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
    public function throwsIfDriverConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAuxConfig($this->getAuxConfigMock())
                ->withLoopConfig($this->getLoopConfigMock())
                ->withOutputConfig($this->getOutputConfigMock())
                ->withWidgetConfig($this->getWidgetConfigMock())
                ->withRootWidgetConfig($this->getWidgetConfigMock())
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
    public function throwsIfWidgetConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'WidgetConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAuxConfig($this->getAuxConfigMock())
                ->withLoopConfig($this->getLoopConfigMock())
                ->withOutputConfig($this->getOutputConfigMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->withRootWidgetConfig($this->getWidgetConfigMock())
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
    public function throwsIfRootWidgetConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'RootWidgetConfig is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withAuxConfig($this->getAuxConfigMock())
                ->withLoopConfig($this->getLoopConfigMock())
                ->withOutputConfig($this->getOutputConfigMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->withWidgetConfig($this->getWidgetConfigMock())
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
