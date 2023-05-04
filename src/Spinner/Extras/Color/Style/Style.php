<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Style;

use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptions;

final readonly class Style implements IStyle
{
    public function __construct(
        protected IColor|string|null $fgColor = null,
        protected IColor|string|null $bgColor = null,
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
