<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color\Style;

use AlecRabbit\Spinner\Extras\Color\Style\StyleOptions;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;
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
