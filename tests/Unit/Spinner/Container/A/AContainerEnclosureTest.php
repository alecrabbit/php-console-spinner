<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Container\A\Override\AContainerEnclosureOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;

final class AContainerEnclosureTest extends TestCase
{
    private const CONTAINER = 'container';
    private static ?ContainerInterface $container;

    #[Test]
    public function canSetContainer(): void
    {
        $container = $this->getContainerMock();
        AContainerEnclosureOverride::setContainer($container);

        $this->assertSame($container, self::extractContainer());
    }

    private function getContainerMock(): MockObject&ContainerInterface
    {
        return $this->createMock(ContainerInterface::class);
    }

    protected static function setContainer(?ContainerInterface $container): void
    {
        self::setPropertyValue(AContainerEnclosureOverride::class, self::CONTAINER, $container);
    }

    protected static function extractContainer(): mixed
    {
        return self::getPropertyValue(self::CONTAINER, AContainerEnclosureOverride::class);
    }

    #[Test]
    public function throwsExceptionWhenContainerIsNotSet(): void
    {
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Container is not set.');

        self::callMethod(AContainerEnclosureOverride::class, 'getContainer');
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(null);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
}
