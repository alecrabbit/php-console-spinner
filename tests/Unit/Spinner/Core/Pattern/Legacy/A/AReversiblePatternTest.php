<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\A\AReversiblePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class AReversiblePatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(AReversiblePattern::class, $pattern);
        self::assertFalse($pattern->isReversed());
    }

    protected function getTesteeInstance(
        ?Traversable $entries = null,
        ?int $interval = null,
        ?bool $reversed = null,
    ): ILegacyPattern {
        return
            new class(
                entries: $entries,
                interval: $interval,
                reversed: $reversed ?? false,
            ) extends AReversiblePattern {
            };
    }

    #[Test]
    public function canBeReversed(): void
    {
        $pattern = $this->getTesteeInstance(
            reversed: true,
        );
        self::assertInstanceOf(AReversiblePattern::class, $pattern);
        self::assertTrue($pattern->isReversed());
    }

}
