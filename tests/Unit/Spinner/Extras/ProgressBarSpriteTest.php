<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Tests\TestCase\TestCase;

final class ProgressBarSpriteTest extends TestCase
{
    /** @test */
    public function canCreateDefault(): void
    {
        $instance = new ProgressBarSprite();
        self::assertSame('', $instance->getOpen());
        self::assertSame('', $instance->getClose());
        self::assertSame('█', $instance->getDone());
        self::assertSame('▓', $instance->getCursor());
        self::assertSame('░', $instance->getEmpty());
    }

    /** @test */
    public function canCreate(): void
    {
        $instance = new ProgressBarSprite(
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
