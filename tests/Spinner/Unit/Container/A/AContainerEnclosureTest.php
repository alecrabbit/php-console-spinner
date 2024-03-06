<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\A;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;
use stdClass;

use function AlecRabbit\Tests\TestCase\Sneaky\peek;

final class AContainerEnclosureTest extends TestCase
{
    private static ?ContainerInterface $container;
    private static ?string $factoryClass;

    #[Test]
    public function canUseFactoryClass(): void
    {
        $factory = $this->getContainerBuilderFactoryMock();

        AContainerEnclosure::useFactoryClass($factory::class);

        self::assertInstanceOf(IContainer::class, self::extractContainer());
    }

    private function getContainerBuilderFactoryMock(): MockObject&IContainerBuilderFactory
    {
        return $this->createMock(IContainerBuilderFactory::class);
    }

    private static function extractContainer(): mixed
    {
        return peek(AContainerEnclosure::class)->getContainer();
    }

    #[Test]
    public function throwsIfContainerBuilderClassFactoryIsInvalid(): void
    {
        $class = stdClass::class;
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Container builder class must implement [%s]. "%s" given.',
                IContainerBuilderFactory::class,
                $class,
            )
        );
        AContainerEnclosure::useFactoryClass($class);
    }

    #[Test]
    public function throwsIfContainerBuilderClassFactoryIsNotSet(): void
    {
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Container builder factory class must be set.');
        self::extractContainer();
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::$factoryClass = peek(AContainerEnclosure::class)->factoryClass;

        self::setContainer(null);
        peek(AContainerEnclosure::class)->factoryClass = null;
        parent::setUp();
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        peek(AContainerEnclosure::class)->setContainer($container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        peek(AContainerEnclosure::class)->factoryClass = self::$factoryClass;
        self::setContainer(self::$container);
    }
}
