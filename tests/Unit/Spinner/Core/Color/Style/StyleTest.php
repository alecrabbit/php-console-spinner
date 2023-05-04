<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Color\Style;

use AlecRabbit\Spinner\Contract\Color\Style\StyleOption;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Color\Style\StyleOptions;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StyleTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $fgColor = '#000000';
        $bgColor = '#000000';
        $options = new StyleOptions(StyleOption::BOLD);
        $format = ' %s ';
        $width = 2;
        $style = new Style(
            fgColor: $fgColor,
            bgColor: $bgColor,
            options: $options,
            format: $format,
            width: $width,
        );

        self::assertSame($fgColor, $style->getFgColor());
        self::assertSame($bgColor, $style->getBgColor());
        self::assertSame($options, $style->getOptions());
        self::assertSame($format, $style->getFormat());
        self::assertSame($width, $style->getWidth());
        self::assertFalse($style->isEmpty());
        self::assertFalse($style->isOptionsOnly());
        self::assertTrue($style->hasOptions());
    }
}
