<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\IColorMarker;
use AlecRabbit\Spinner\Contract\IOptions;
use AlecRabbit\Spinner\Contract\IStyle;

final readonly class Style implements IStyle
{
    public function __construct(
        protected null|string|IColorMarker $fgColor = null,
        protected null|string|IColorMarker $bgColor = null,
        protected ?IOptions $options = null,
        protected string $format = '%s',
        protected int $width = 0,
    ) {
    }

    public function isEmpty(): bool
    {
        return null === $this->fgColor && null === $this->bgColor && null === $this->options;
    }

    public function getFgColor(): IColorMarker|string|null
    {
        return $this->fgColor;
    }

    public function getBgColor(): IColorMarker|string|null
    {
        return $this->bgColor;
    }

    public function getOptions(): IOptions|null
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
        return null !== $this->options;
    }
}