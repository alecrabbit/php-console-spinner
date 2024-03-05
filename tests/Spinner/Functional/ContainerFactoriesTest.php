<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional;

use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\DI\ContainerFactories;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ContainerFactoriesTest extends TestCase
{
    private const FACTORIES = 'factories';
    private array $factories = [];

    #[Test]
    public function canRegisterContainerFactory(): void
    {
        $factory = $this->getContainerFactoryMock();
        ContainerFactories::register($factory::class);

        $factories = self::getPropertyValue(ContainerFactories::class, self::FACTORIES);

        self::assertContains($factory::class, $factories);
    }

    private function getContainerFactoryMock(): MockObject&IContainerFactory
    {
        return $this->createMock(IContainerFactory::class);
    }

    #[Test]
    public function canLoad(): void
    {
        $factory01 = $this->getContainerFactoryMock();

        $factories = ContainerFactories::load();

        self::assertCount(0, $factories);
        self::assertNotContains($factory01::class, $factories);

        ContainerFactories::register($factory01::class);

        $factories = ContainerFactories::load();

        self::assertCount(1, $factories);
        self::assertContains($factory01::class, $factories);
    }

    #[Test]
    public function throwsIfFactoryClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf('Class "%s" must implement "%s".', 'stdClass', IContainerFactory::class)
        );
        ContainerFactories::register(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->factories = self::getPropertyValue(ContainerFactories::class, self::FACTORIES);
        $this->setFactories([]);
    }

    protected function setFactories(array $factories): void
    {
        self::setPropertyValue(ContainerFactories::class, self::FACTORIES, $factories);
    }

    protected function tearDown(): void
    {
        $this->setFactories($this->factories);
    }
}
