<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;


use AlecRabbit\Spinner\Container\CircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Exception\CircularDependencyDetected;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class CircularDependencyDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();
        self::assertInstanceOf(CircularDependencyDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?ArrayObject $stack = null,
    ): ICircularDependencyDetector {
        return
            new CircularDependencyDetector(
                stack: $stack ?? new ArrayObject(),
            );
    }

    #[Test]
    public function canPush(): void
    {
        $stack = new ArrayObject([]);
        $detector =
            $this->getTesteeInstance(
                stack: $stack,
            );

        $detector->push('id');

        self::assertCount(1, $stack);
    }

    #[Test]
    public function canPop(): void
    {
        $stack = new ArrayObject(['id']);
        $detector =
            $this->getTesteeInstance(
                stack: $stack,
            );

        $detector->pop();

        self::assertCount(0, $stack);
    }

    #[Test]
    public function canPopTwo(): void
    {
        $stack = new ArrayObject(['first', 'second']);
        $detector =
            $this->getTesteeInstance(
                stack: $stack,
            );

        $detector->pop();

        self::assertCount(1, $stack);

        $arrayCopy = $stack->getArrayCopy();

        self::assertContains('first', $arrayCopy);
        self::assertNotContains('second', $arrayCopy);
    }

    #[Test]
    public function throwsIfCircularDependencyDetected(): void
    {
        $id = 'id';
        $detector = $this->getTesteeInstance();

        $detector->push($id);

        $this->expectException(CircularDependencyDetected::class);
        $this->expectExceptionMessage('Circular dependency detected!');

        $detector->push($id);
    }
}
