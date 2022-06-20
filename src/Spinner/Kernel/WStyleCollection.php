<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\IStyle;
use AlecRabbit\Spinner\Kernel\Contract\IWStyleCollection;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Rotor\WInterval;
use ArrayIterator;
use Traversable;

final class WStyleCollection implements IWStyleCollection
{
    /** @var array<int, IStyle> */
    private array $elements = [];
    private int $count = 0;

    protected function __construct(
        private readonly IWInterval $interval
    ) {
    }

    public static function create(array $styles = [], ?int $interval = null): IWStyleCollection
    {
        self::assert($styles);
        $collection = new self(new WInterval($interval));

        foreach ($styles as $style) {
            $collection->add(Style::create($style));
        }
        if ($collection->isEmpty()) {
            $collection->add(Style::create());
        }
        return $collection;
    }

    private static function assert(array $styles): void
    {
        // TODO (2022-06-15 17:37) [Alec Rabbit]: Implement.
    }

    public function add(IStyle $style): void
    {
        $this->count++;
        $this->elements[] = $style;
    }

    protected function isEmpty(): bool
    {
        return 0 === $this->count;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function getInterval(): IWInterval
    {
        return $this->interval;
    }

    public function count(): int
    {
        return $this->count;
    }
}
