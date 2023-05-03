<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\StylePattern;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\ICharPattern;
use AlecRabbit\Spinner\Core\Pattern\NoCharPattern;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class NoCharPatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(NoCharPattern::class, $pattern);
    }

    public function getTesteeInstance(): ICharPattern
    {
        return new NoCharPattern();
    }

    #[Test]
    public function canGetEntries(): void
    {
        $frame = new CharFrame('', 0);
        $pattern = $this->getTesteeInstance();

        $frames = iterator_to_array($pattern->getEntries());

        self::assertInstanceOf(NoCharPattern::class, $pattern);
        self::assertCount(1, $frames);
        self::assertEquals($frame, reset($frames));
    }
}
