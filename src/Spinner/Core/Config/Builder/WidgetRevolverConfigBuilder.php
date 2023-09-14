<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetRevolverConfigBuilder implements IWidgetRevolverConfigBuilder
{
    private ?IPalette $stylePalette = null;
    private ?IPalette $charPalette = null;

    /**
     * @inheritDoc
     */
    public function build(): IWidgetRevolverConfig
    {
        $this->validate();

        return
            new WidgetRevolverConfig(
                stylePalette: $this->stylePalette,
                charPalette: $this->charPalette,
            );
    }


    public function withStylePalette(IPalette $palette): IWidgetRevolverConfigBuilder
    {
        $clone = clone $this;
        $clone->stylePalette = $palette;
        return $clone;
    }

    public function withCharPalette(IPalette $palette): IWidgetRevolverConfigBuilder
    {
        $clone = clone $this;
        $clone->charPalette = $palette;
        return $clone;
    }

    private function validate(): void
    {
        match (true) {
            $this->stylePalette === null => throw new LogicException('Style palette is not set.'),
            $this->charPalette === null => throw new LogicException('Char palette is not set.'),
            default => null,
        };
    }
}
