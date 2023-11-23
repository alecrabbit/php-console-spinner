<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Builder\DriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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

        $driverMessages = $this->getDriverMessagesMock();

        $config = $configBuilder
            ->withDriverMessages($driverMessages)
            ->withDriverMode(DriverMode::DISABLED)
            ->build()
        ;

        self::assertInstanceOf(DriverConfig::class, $config);

        self::assertSame($driverMessages, $config->getDriverMessages());
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    #[Test]
    public function throwsIfLinkerModeModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverMessages is not set.';

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

    #[Test]
    public function throwsIfDriverModeIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverMode is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withDriverMessages($this->getDriverMessagesMock())
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
