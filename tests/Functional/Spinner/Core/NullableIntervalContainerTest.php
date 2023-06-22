<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core;

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalContainer;
use AlecRabbit\Spinner\Core\NullableIntervalContainer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NullableIntervalContainerTest extends TestCase
{
    #[Test]
    public function canOperateWithIntervals(): void
    {
        $intervalContainer = new NullableIntervalContainer();

        $interval0 = new Interval(100);
        $interval1 = new Interval(200);
        $interval2 = new Interval(300);
        $interval3 = new Interval(400);
        $interval4 = new Interval(800);
        $interval5 = new Interval(1000);

        $intervalContainer->add($interval0);
        $intervalContainer->add($interval1);
        $intervalContainer->add($interval2);
        $intervalContainer->add($interval3);
        $intervalContainer->add($interval4);
        $intervalContainer->add($interval5);

        self::assertSame($interval0, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval1);
        self::assertSame($interval0, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval0);
        self::assertSame($interval2, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval2);
        self::assertSame($interval3, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval5);
        self::assertSame($interval3, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval3);
        self::assertSame($interval4, $intervalContainer->getSmallest());
        $intervalContainer->remove($interval4);
        self::assertNull($intervalContainer->getSmallest());
    }
}
