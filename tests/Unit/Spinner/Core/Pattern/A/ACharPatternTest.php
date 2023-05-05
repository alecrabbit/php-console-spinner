<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\A\ACharPattern;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class ACharPatternTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(ACharPattern::class, $pattern);
        self::assertFalse($pattern->isReversed());
    }

    protected function getTesteeInstance(
        ?Traversable $entries = null,
        ?int $interval = null,
        ?bool $reversed = null,
    ): IPattern {
        return
            new class(
                entries: $entries,
                interval: $interval,
                reversed: $reversed ?? false,
            ) extends ACharPattern {
            };
    }

    #[Test]
    public function canBeReversed(): void
    {
        $pattern = $this->getTesteeInstance(
            reversed: true,
        );
        self::assertInstanceOf(ACharPattern::class, $pattern);
        self::assertTrue($pattern->isReversed());
    }

    #[Test]
    public function canGetEntries(): void
    {
        $entries = new ArrayObject([]);
        $pattern = $this->getTesteeInstance(entries: $entries);
        self::assertInstanceOf(ACharPattern::class, $pattern);
        self::assertSame($entries, $pattern->getEntries());
    }

}