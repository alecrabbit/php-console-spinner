<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

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
