<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Color\Style;

use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptions;
use AlecRabbit\Spinner\Contract\Color\Style\StyleOption;
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
        return new \ArrayIterator($this->options);
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->options);
    }
}
