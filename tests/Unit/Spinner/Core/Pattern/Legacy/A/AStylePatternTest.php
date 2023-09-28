<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Legacy\A\AStylePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Traversable;

final class AStylePatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(AStylePattern::class, $pattern);
        self::assertFalse($pattern->isReversed());
    }

    protected function getTesteeInstance(
        ?int $interval = null,
        ?bool $reversed = null,
    ): ILegacyPattern {
        return
            new class(
                interval: $interval,
                reversed: $reversed ?? false,
            ) extends AStylePattern {
                public function getEntries(StylingMethodOption $styleMode = StylingMethodOption::ANSI8): Traversable
                {
                    throw new RuntimeException('Not implemented');
                }

            };
    }

    #[Test]
    public function canBeReversed(): void
    {
        $pattern = $this->getTesteeInstance(
            reversed: true,
        );
        self::assertInstanceOf(AStylePattern::class, $pattern);
        self::assertTrue($pattern->isReversed());
    }

    #[Test]
    public function canStyleMode(): void
    {
        $pattern = $this->getTesteeInstance();
        self::assertInstanceOf(AStylePattern::class, $pattern);
        self::assertSame(StylingMethodOption::ANSI8, $pattern->getStyleMode());
    }

    #[Test]
    public function throwsIfGetEntries(): void
    {
        $this->wrapExceptionTest(
            function (): void {
                $pattern = $this->getTesteeInstance();
                self::assertInstanceOf(AStylePattern::class, $pattern);
                $pattern->getEntries();
            },
            new RuntimeException('Not implemented'),
        );
    }

}
