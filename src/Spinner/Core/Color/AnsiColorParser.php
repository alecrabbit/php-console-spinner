<?php

declare(strict_types=1);

// 15.04.23

namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class AnsiColorParser implements IAnsiColorParser
{
    private const FORMAT = '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/';

    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parseColor(IColor|null|string $color): string
    {
        if ($color === '' || $color === null) {
            return '';
        }

        self::assertValid($color);

        return $this->converter->convert($color);
    }

    private static function assertValid(IColor|string $color): void
    {
        match (true) {
            self::correctFormat($color) => null,
            default => throw new InvalidArgumentException(
                sprintf('Invalid color format: "%s".,', $color)
            ),
        };
    }

    private static function correctFormat(IColor|string $color): bool
    {
        if ($color instanceof IColor) {
            return false; // not supported yet
        }
        return (bool)preg_match(self::FORMAT, $color);
    }
}
