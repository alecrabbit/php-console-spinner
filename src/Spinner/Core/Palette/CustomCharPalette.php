<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use ArrayObject;
use Closure;

final class CustomCharPalette extends ACharPalette
{
    public function __construct(
        ArrayObject $frames,
        IPaletteOptions $options = new PaletteOptions(),
        int $index = 0,
    ) {
        parent::__construct(
            $this->refine($frames),
            $options,
            $index,
        );
    }

    private function refine(ArrayObject $frames): ArrayObject
    {
        $frames = $this->filter($frames);

        if ($frames->count() === 0) {
            return new ArrayObject(
                [
                    $this->getEmptyFrame()
                ],
            );
        }

        return $frames;
    }

    private function filter(ArrayObject $frames): ArrayObject
    {
        return new ArrayObject(
            array_filter(
                $frames->getArrayCopy(),
                $this->getFilterClosure(),
            )
        );
    }

    private function getFilterClosure(): Closure
    {
        return static fn(mixed $frame) => $frame instanceof ICharSequenceFrame;
    }

    private function getEmptyFrame(): ISequenceFrame
    {
        return new CharSequenceFrame('', 0);
    }
}
