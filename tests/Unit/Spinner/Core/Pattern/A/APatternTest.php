<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class APatternTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(APattern::class, $pattern);
        self::assertNull($pattern->getInterval());
    }

    protected function getTesteeInstance(
        ?Traversable $entries = null,
        ?int $interval = null,
    ): IPattern {
        return
            new class(
                entries: $entries,
                interval: $interval,
            ) extends APattern {
            };
    }
}
