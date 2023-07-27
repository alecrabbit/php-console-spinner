<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Pattern\A\ABakedPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Override\ABakedPatternOverride;
use PHPUnit\Framework\Attributes\Test;

final class ABakedPatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(ABakedPattern::class, $pattern);
    }

    protected function getTesteeInstance(
        ?IFrameCollection $frames = null,
        ?IInterval $interval = null,
    ): IBakedPattern {
        return
            new ABakedPatternOverride(
                frames: $frames ?? $this->getFrameCollectionMock(),
                interval: $interval ?? $this->getIntervalMock(),
            );
    }

    #[Test]
    public function valuesCanBeRetrieved(): void
    {
        $frames = $this->getFrameCollectionMock();
        $interval = $this->getIntervalMock();
        $pattern = $this->getTesteeInstance(
            frames: $frames,
            interval: $interval,
        );
        self::assertInstanceOf(ABakedPattern::class, $pattern);
        self::assertSame($frames, $pattern->getFrameCollection());
        self::assertSame($interval, $pattern->getInterval());
    }
}
