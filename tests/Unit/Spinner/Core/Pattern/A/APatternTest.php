<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\A;


use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Override\APatternOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class APatternTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $entries = new ArrayObject([]);
        $interval = new Interval();
        $pattern = $this->getTesteeInstance(
            entries: $entries,
            interval: $interval,
        );
        self::assertInstanceOf(APattern::class, $pattern);
    }

    protected function getTesteeInstance(
        ?Traversable $entries = null,
        ?Interval $interval = null,
    ): IPattern {
        return
            new APatternOverride(
                entries: $entries ?? new ArrayObject([]),
                interval: $interval ?? new Interval(),
            );
    }
}
