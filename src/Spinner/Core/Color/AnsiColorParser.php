<?php

declare(strict_types=1);
// 15.04.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class AnsiColorParser implements IAnsiColorParser
{
    protected const FORMAT = '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/';

    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parseColor(string $color): string
    {
        if ('' === $color) {
            return '';
        }

        self::assertValid($color);

        return $this->converter->convert($color);
    }

    protected static function assertValid(string $color): void
    {
        match (true) {
            self::correctFormat($color) => null,
            default => throw new InvalidArgumentException(
                sprintf('Invalid color format: "%s".,', $color)
            ),
        };
    }

    protected static function correctFormat(string $color): bool
    {
        return (bool)preg_match(self::FORMAT, $color);
    }
}
