<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetBuilderTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(WidgetBuilder::class, $builder);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IWidgetBuilder {
        return
            new WidgetBuilder(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }
//
//    #[Test]
//    public function canBuildDriverWithDriverConfig(): void
//    {
//        $container = $this->createMock(IContainer::class);
//        $container
//            ->method('get')
//            ->willReturn(new DefaultsProvider());
//
//        $driverBuilder = $this->getTesteeInstance(container: $container);
//
//        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);
//
//        $driverConfig = new DriverConfig('interrupted', 'finished');
//        $driver = $driverBuilder->withDriverConfig($driverConfig)->build();
//
//        self::assertInstanceOf(Driver::class, $driver);
//    }
//
//    #[Test]
//    public function throwsOnBuildDriverWithoutDriverConfig(): void
//    {
//        $container = $this->createMock(IContainer::class);
//        $container
//            ->method('get')
//            ->willReturn(new DefaultsProvider());
//
//        $driverBuilder = $this->getTesteeInstance(container: $container);
//
//        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);
//
//        $exceptionClass = \LogicException::class;
//        $exceptionMessage = '[AlecRabbit\Spinner\Core\Config\DriverBuilder]: Property $driverConfig is not set.';
//
//        $this->expectException($exceptionClass);
//        $this->expectExceptionMessage($exceptionMessage);
//
//        $driver = $driverBuilder->build();
//
//        self::exceptionNotThrown($exceptionClass, $exceptionMessage);
//    }
}
