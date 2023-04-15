<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\A\AColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class HexColorToAnsiCodeConverter extends AColorToAnsiCodeConverter implements IHexColorToAnsiCodeConverter
{
    /** @inheritdoc */
    public function convert(string $color): string
    {
        $color = $this->normalize($color);

        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => $this->convert4($color),
                OptionStyleMode::ANSI8 => $this->convert8($color),
                default => $this->convertHexColorToAnsiColorCode($color),
            };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertHexColorToAnsiColorCode(string $hexColor): string
    {
        $color = $this->toInt($hexColor);

        $r = ($color >> 16) & 255;
        $g = ($color >> 8) & 255;
        $b = $color & 255;

        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Failed to convert color "%s" in mode "%s".',
                        $hexColor,
                        $this->styleMode->name,
                    )
                )
            };
    }
}
