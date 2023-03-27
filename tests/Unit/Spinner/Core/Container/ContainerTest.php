<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Container;

use AlecRabbit\Spinner\Core\Container\Container;
use AlecRabbit\Spinner\Core\Container\Exception\ContainerException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeCreatedEmpty(): void
    {
        $container = new Container([]);

        $this->assertFalse($container->has('foo'));
        $this->assertCount(0, self::getValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedWithDefinitions(): void
    {
        $container = new Container([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertTrue($container->has('foo'));
        $this->assertTrue($container->has('bar'));
        $this->assertCount(2, self::getValue('definitions', $container));
    }

    #[Test]
    public function canBeCreatedOnlyWithValidDefinitions(): void
    {
        $exception = ContainerException::class;
        $exceptionMessage = 'Definition should be callable, object or string, integer given.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $container = new Container([
            'foo' => 'bar',
            'baz' => 1,
        ]);

        self::exceptionNotThrown($exception, $exceptionMessage);
    }
}