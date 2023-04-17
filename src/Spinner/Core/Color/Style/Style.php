<?php

declare(strict_types=1);

// 24.03.23

namespace AlecRabbit\Spinner\Core\Color\Style;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptions;

final readonly class Style implements IStyle
{
    public function __construct(
        protected null|string|IColor $fgColor = null,
        protected null|string|IColor $bgColor = null,
        protected ?IStyleOptions $options = null,
        protected string $format = '%s',
        protected int $width = 0,
    ) {
    }

    public function isEmpty(): bool
    {
        return $this->fgColor === null
            && $this->bgColor === null
            && $this->noOptions();
    }

    private function noOptions(): bool
    {
        return $this->options === null || $this->options->isEmpty();
    }

    public function getFgColor(): IColor|string|null
    {
        return $this->fgColor;
    }

    public function getBgColor(): IColor|string|null
    {
        return $this->bgColor;
    }

    public function getOptions(): IStyleOptions|null
    {
        return $this->options;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function isOptionsOnly(): bool
    {
        return $this->hasOptions() && $this->fgColor === null && $this->bgColor === null;
    }

    public function hasOptions(): bool
    {
        return !$this->noOptions();
    }
}
