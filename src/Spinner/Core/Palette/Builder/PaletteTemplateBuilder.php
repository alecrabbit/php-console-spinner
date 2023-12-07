<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class PaletteTemplateBuilder implements IPaletteTemplateBuilder
{
    /**
     * @var Traversable<IFrame>|null
     */
    private ?Traversable $entries = null;
    private ?IPaletteOptions $options = null;

    public function build(): IPaletteTemplate
    {
        $this->validate();

        return new PaletteTemplate(
            entries: $this->entries,
            options: $this->options,
        );
    }

    /**
     * @throws InvalidArgument
     */
    private function validate(): void
    {
        match (true) {
            $this->entries === null => throw new InvalidArgument('Entries are not set.'),
            $this->options === null => throw new InvalidArgument('Options are not set.'),
            default => null,
        };
    }

    /** @inheritDoc */
    public function withEntries(Traversable $entries): IPaletteTemplateBuilder
    {
        $clone = clone $this;
        $clone->entries = $entries;
        return $clone;
    }

    public function withOptions(IPaletteOptions $options): IPaletteTemplateBuilder
    {
        $clone = clone $this;
        $clone->options = $options;
        return $clone;
    }
}
