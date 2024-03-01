<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\A;

use AlecRabbit\Spinner\Container\A\AContainerEnclosure;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\Spinner\Unit\Container\A\Override\AContainerEnclosureOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;
use stdClass;

final class AContainerEnclosureTest extends TestCase
{
    private const GET_CONTAINER = 'getContainer';
    private const SET_CONTAINER = 'setContainer';
    private static ?ContainerInterface $container;

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
        return self::callMethod(AContainerEnclosureOverride::class, self::GET_CONTAINER);
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

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        self::callMethod(AContainerEnclosureOverride::class, self::SET_CONTAINER, $container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
