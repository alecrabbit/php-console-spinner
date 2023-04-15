<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Color\Style;

use AlecRabbit\Spinner\Contract\Color\IStringableColor;
use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptions;

final readonly class Style implements IStyle
{
    public function __construct(
        protected null|string|IStringableColor $fgColor = null,
        protected null|string|IStringableColor $bgColor = null,
        protected ?IStyleOptions $options = null,
        protected string $format = '%s',
        protected int $width = 0,
    ) {
    }

    public function isEmpty(): bool
    {
        return
            null === $this->fgColor
            && null === $this->bgColor
            && $this->noOptions();
    }

    protected function noOptions(): bool
    {
        return null === $this->options || $this->options->isEmpty();
    }

    public function getFgColor(): IStringableColor|string|null
    {
        return $this->fgColor;
    }

    public function getBgColor(): IStringableColor|string|null
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
        return $this->hasOptions() && null === $this->fgColor && null === $this->bgColor;
    }

    public function hasOptions(): bool
    {
        return !$this->noOptions();
    }
}
