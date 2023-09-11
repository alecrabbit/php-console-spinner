<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

class RevolverConfigBuilder implements IRevolverConfigBuilder
{
    private ?IPalette $stylePalette = null;
    private ?IPalette $charPalette = null;

    /**
     * @inheritDoc
     */
    public function build(): IRevolverConfig
    {
        $this->validate();

        return
            new RevolverConfig(
                stylePalette: $this->stylePalette,
                charPalette: $this->charPalette,
            );
    }


    public function withStylePalette(IPalette $palette): IRevolverConfigBuilder
    {
        $clone = clone $this;
        $clone->stylePalette = $palette;
        return $clone;
    }

    public function withCharPalette(IPalette $palette): IRevolverConfigBuilder
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
