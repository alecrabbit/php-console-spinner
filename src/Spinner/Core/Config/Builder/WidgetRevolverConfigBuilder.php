<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
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
    private ?IRevolverConfig $revolverConfig = null;

    public function build(): IWidgetRevolverConfig
    {
        $this->validate();

        return new WidgetRevolverConfig(
            stylePalette: $this->stylePalette,
            charPalette: $this->charPalette,
            revolverConfig: $this->revolverConfig,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->stylePalette === null => throw new LogicException('Style palette is not set.'),
            $this->charPalette === null => throw new LogicException('Char palette is not set.'),
            $this->revolverConfig === null => throw new LogicException('Revolver config is not set.'),
            default => null,
        };
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

    public function withRevolverConfig(IRevolverConfig $revolverConfig): IWidgetRevolverConfigBuilder
    {
        $clone = clone $this;
        $clone->revolverConfig = $revolverConfig;
        return $clone;
    }
}
