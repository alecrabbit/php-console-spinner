<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\A\ALegacyPattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class APatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(ALegacyPattern::class, $pattern);
        self::assertNull($pattern->getInterval());
    }

    protected function getTesteeInstance(
        ?Traversable $entries = null,
        ?int $interval = null,
    ): ILegacyPattern {
        return
            new class(
                entries: $entries,
                interval: $interval,
            ) extends ALegacyPattern {
            };
    }

    #[Test]
    public function isReversedReturnsFalse(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(ALegacyPattern::class, $pattern);
        self::assertFalse($pattern->isReversed());
    }
}
