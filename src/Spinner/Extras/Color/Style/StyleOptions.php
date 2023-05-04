<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Style;

use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptions;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;
use ArrayIterator;
use Traversable;

final class StyleOptions implements IStyleOptions
{
    private array $options;

    public function __construct(StyleOption ...$options)
    {
        $this->options = $options;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->options);
    }

    public function isEmpty(): bool
    {
        return count($this->options) === 0;
    }
}
