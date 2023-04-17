<?php

declare(strict_types=1);

// 15.02.23

namespace AlecRabbit\Tests\Unit\Spinner\Core\Color\Style;

use AlecRabbit\Spinner\Contract\Color\Style\StyleOption;
use AlecRabbit\Spinner\Core\Color\Style\StyleOptions;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StyleOptionsTest extends TestCase
{
    #[Test]
    public function canBeCreatedEmpty(): void
    {
        $options = new StyleOptions();

        self::assertTrue($options->isEmpty());
    }

    #[Test]
    public function canBeCreated(): void
    {
        $options = new StyleOptions(StyleOption::BOLD);

        self::assertFalse($options->isEmpty());
        self::assertCount(1, $options->getIterator());
    }
}
