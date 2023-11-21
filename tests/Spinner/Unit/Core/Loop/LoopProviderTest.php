<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Loop;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Loop\LoopProvider;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopProviderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopProvider::class, $driverBuilder);
    }

    public function getTesteeInstance(?ILoop $loop = null): ILoopProvider
    {
        return
            new LoopProvider(
                loop: $loop,
            );
    }

    #[Test]
    public function canGetLoop(): void
    {
        $loop = $this->getLoopMock();

        $loopProvider = $this->getTesteeInstance(
            loop: $loop,
        );

        self::assertSame($loop, $loopProvider->getLoop());
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    #[Test]
    public function hasLoopIfLoopIsSet(): void
    {
        $loop = $this->getLoopMock();

        $loopProvider = $this->getTesteeInstance(
            loop: $loop,
        );

        self::assertTrue($loopProvider->hasLoop());
    }

    #[Test]
    public function doesNotHaveLoopIfLoopIsNotSet(): void
    {
        $loopProvider = $this->getTesteeInstance();

        self::assertFalse($loopProvider->hasLoop());
    }

    #[Test]
    public function throwsOnGetLoopIfLoopIsNotSet(): void
    {
        $loopProvider = $this->getTesteeInstance();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        self::assertNull($loopProvider->getLoop());

        self::fail('Exception was not thrown.');
    }

}
