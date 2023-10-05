<?php

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Legacy\StylePattern;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoStylePattern;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class NoStylePatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(NoStylePattern::class, $pattern);
    }

    public function getTesteeInstance(): IStyleLegacyPattern
    {
        return new NoStylePattern();
    }

    #[Test]
    public function canGetStyleMode(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(NoStylePattern::class, $pattern);
        self::assertEquals(StylingMethodOption::NONE, $pattern->getStyleMode());
    }

    #[Test]
    public function canGetEntries(): void
    {
        $frame = new StyleFrame('%s', 0);
        $pattern = $this->getTesteeInstance();

        $frames = iterator_to_array($pattern->getEntries());

        self::assertInstanceOf(NoStylePattern::class, $pattern);
        self::assertCount(1, $frames);
        self::assertEquals($frame, reset($frames));
    }
}
