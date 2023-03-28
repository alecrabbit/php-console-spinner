<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Extras\A;

use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Extras\A\Override\AProgressBarSpriteOverride;

final class AProgressBarSpriteTest extends TestCase
{
    /** @test */
    public function canCreateDefault(): void
    {
        $instance = new AProgressBarSpriteOverride();
        self::assertSame('', $instance->getOpen());
        self::assertSame('', $instance->getClose());
        self::assertSame('█', $instance->getDone());
        self::assertSame('▓', $instance->getCursor());
        self::assertSame('░', $instance->getEmpty());
    }

    /** @test */
    public function canCreate(): void
    {
        $instance = new AProgressBarSpriteOverride(
            empty: 'e',
            done: 'd',
            cursor: 'c',
            open: 'o',
            close: 'f',
        );
        self::assertSame('e', $instance->getEmpty());
        self::assertSame('d', $instance->getDone());
        self::assertSame('c', $instance->getCursor());
        self::assertSame('o', $instance->getOpen());
        self::assertSame('f', $instance->getClose());
    }
}