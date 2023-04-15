<?php
declare(strict_types=1);
// 15.04.23
namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsiColorParser;

final class AnsiColorParser implements IAnsiColorParser
{
    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parse(string $color): string
    {
        if ('' === $color) {
            return '';
        }

        if ($this->correctFormat($color)) {
            return $this->converter->convert($color);
        }

        throw new InvalidArgumentException('Invalid color format: ' . $color);
    }

    private function correctFormat(string $color): bool
    {
        return '#' === $color[0];
//        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $color);
    }
}
