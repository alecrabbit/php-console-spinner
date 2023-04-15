<?php

declare(strict_types=1);
// 15.04.23
namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsiColorParser;

final class AnsiColorParser implements IAnsiColorParser
{
    protected const FORMAT = '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/';

    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parse(string $color): string
    {
        if ('' === $color) {
            return '';
        }

        self::assertValid($color);
        
        return $this->converter->convert($color);
    }

    protected static function assertValid(string $color): void
    {
        if (self::correctFormat($color)) {
            return;
        }
        throw new InvalidArgumentException('Invalid color format: ' . $color);
    }

    protected static function correctFormat(string $color): bool
    {
        return (bool)preg_match(self::FORMAT, $color);
    }
}
