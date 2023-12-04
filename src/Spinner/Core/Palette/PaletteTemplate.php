<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use Traversable;

final readonly class PaletteTemplate implements IPaletteTemplate
{
    /** @var Traversable<IFrame> $entries */
    private Traversable $entries;

    /**
     * @param Traversable<IFrame> $entries
     */
    public function __construct(
        Traversable $entries,
        protected IPaletteOptions $options = new PaletteOptions(),
    ) {
        $this->entries = $entries;
    }

    /**
     * @return Traversable<IFrame>
     */
    public function getEntries(): Traversable
    {
        if ($this->options->getReversed()) {
            return $this->reversed($this->entries);
        }
        return $this->entries;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }

    /**
     * @param Traversable<IFrame> $entries
     * @return Traversable<IFrame>
     */
    private function reversed(Traversable $entries): Traversable
    {
        $sequence = [];

        foreach ($entries as $entry) {
            $sequence[] = $entry;
        }

        yield from array_reverse($sequence);
    }
}
