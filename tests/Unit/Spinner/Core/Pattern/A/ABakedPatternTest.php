<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Pattern\IBakedPattern;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\A\ABakedPattern;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Override\ABakedPatternOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class ABakedPatternTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $entries = new ArrayObject([]);
        $interval = new Interval();
        $pattern = $this->getTesteeInstance(
            frames: $entries,
            interval: $interval,
        );
        self::assertInstanceOf(ABakedPattern::class, $pattern);
    }

    protected function getTesteeInstance(
        ?Traversable $frames = null,
        ?Interval $interval = null,
    ): IBakedPattern {
        return
            new ABakedPatternOverride(
                frames: $frames ?? new ArrayObject([]),
                interval: $interval ?? new Interval(),
            );
    }
}
