<?php
declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Color\A;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Mixin\AnsiColorTableTrait;

abstract class AColorToAnsiCodeConverter
{
    use AnsiColorTableTrait;

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
}
