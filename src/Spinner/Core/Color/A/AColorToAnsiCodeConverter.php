<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Color\A;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\Ansi4Color;
use AlecRabbit\Spinner\Core\Color\Ansi8Color;
use AlecRabbit\Spinner\Core\Color\Mixin\Ansi8ColorTableTrait;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AColorToAnsiCodeConverter
{
    use Ansi8ColorTableTrait;

    public function __construct(
        protected OptionStyleMode $styleMode,
    ) {
        self::assert($this);
    }

    protected static function assert(self $obj): void
    {
        if ($obj->styleMode === OptionStyleMode::NONE) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unsupported style mode "%s".',
                    $obj->styleMode->name,
                )
            );
        }
    }


    /**
     * @throws InvalidArgumentException
     */
    protected function normalize(string $color): string
    {
        $color = strtolower($color);

        $color = str_replace('#', '', $color);

        if (3 === strlen($color)) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }

        $this->assertColor($color);

        return '#' . $color;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertColor(array|string $color): void
    {
        if ('' === $color) {
            throw new InvalidArgumentException('Empty color string.');
        }

        if (6 !== strlen($color)) {
            throw new InvalidArgumentException(sprintf('Invalid color: "#%s".', $color));
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert8(string $color): string
    {
        $index = Ansi8Color::getIndex($color);

        if ($index) {
            return '8;5;' . $index;
        }

        return $this->convertHexColorToAnsiColorCode($color);
    }

    abstract protected function convertHexColorToAnsiColorCode(string $hexColor): string;

    /**
     * @throws InvalidArgumentException
     */
    protected function convert4(string $color): string
    {
        $index = Ansi4Color::getIndex($color);

        if (null !== $index) {
            return (string)$index;
        }

        return $this->convertHexColorToAnsiColorCode($color);
    }

    protected function toInt(string $color): int
    {
        return (int)hexdec(str_replace('#', '', $color));
    }
}
