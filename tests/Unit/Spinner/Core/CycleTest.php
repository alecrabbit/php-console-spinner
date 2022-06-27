<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

class CycleTest extends TestCase
{
    /** @test */
    public function canBeCreated(): void
    {
        $cycle = new Cycle(2);
        self::assertTrue($cycle->completed());
        self::assertFalse($cycle->completed());
        self::assertTrue($cycle->completed());
        self::assertFalse($cycle->completed());
    }
}
