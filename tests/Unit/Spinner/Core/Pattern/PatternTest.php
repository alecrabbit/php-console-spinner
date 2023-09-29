<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Pattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class PatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(Pattern::class, $factory);
    }

    public function getTesteeInstance(
        ?IInterval $interval = null,
        ?Traversable $frames = null
    ): IPattern {
        return new Pattern(
            interval: $interval ?? $this->getIntervalMock(),
            frames: $frames ?? $this->getTraversableMock(),
        );
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $factory = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $factory->getInterval());
    }

    #[Test]
    public function canGetFrames(): void
    {
        $frames = $this->getTraversableMock();

        $factory = $this->getTesteeInstance(
            frames: $frames,
        );

        self::assertSame($frames, $factory->getFrames());
    }
}
