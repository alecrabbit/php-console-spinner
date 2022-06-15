<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IStyle;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Interval;
use ArrayIterator;
use Traversable;

final class StyleCollection implements Contract\IStyleCollection
{
    /** @var array<int, IStyle> */
    private array $elements = [];
    private int $count = 0;

    protected function __construct(
        private readonly IInterval $interval
    ) {
    }

    public static function create(array $styles, ?int $interval = null): Contract\IStyleCollection
    {
        self::assert($styles);
        $collection = new self(new Interval($interval));
        $sequence = $styles['sequence'] ?? [];
        $format = $styles['format'] ?? null;

        foreach ($sequence as $style) {
            if ($style instanceof IStyle) {
                $collection->add($style);
                continue;
            }
            $collection->add(Style::create($style, $format));
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

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
