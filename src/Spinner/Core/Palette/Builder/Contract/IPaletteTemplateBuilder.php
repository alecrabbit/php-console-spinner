<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Builder\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

interface IPaletteTemplateBuilder
{
    /**
     * @throws InvalidArgument
     */
    public function build(): IPaletteTemplate;

    /**
     * @param Traversable<ISequenceFrame> $entries
     */
    public function withEntries(Traversable $entries): IPaletteTemplateBuilder;

    public function withOptions(IPaletteOptions $options): IPaletteTemplateBuilder;
}
