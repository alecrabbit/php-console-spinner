<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use Traversable;

final readonly class PaletteTemplate implements IPaletteTemplate
{
    /** @var IHasFrame|Traversable<ISequenceFrame> $entries */
    private IHasFrame|Traversable $entries;

    /**
     * @param IHasFrame|Traversable<ISequenceFrame> $entries
     * @param IPaletteOptions $options
     */
    public function __construct(
        IHasFrame|Traversable $entries,
        private IPaletteOptions $options,
    ) {
        $this->entries = $entries;
    }

    /**
     * @return IHasFrame|Traversable<ISequenceFrame>
     */
    public function getEntries(): IHasFrame|Traversable
    {
        return $this->entries;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
