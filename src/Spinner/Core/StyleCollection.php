<?php

declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IStyle;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Interval;
use ArrayIterator;
use Traversable;

final class StyleCollection implements Contract\IStyleCollection
{
    /** @var array<int, IStyle> */
    private array $styles = [];
    private int $count = 0;
    private IInterval $interval;

    protected function __construct(?int $interval = null)
    {
        $seconds = ($interval ?? Defaults::MILLISECONDS_INTERVAL) / 1000;
        $this->interval = new Interval($seconds);
    }

    public static function create(iterable $styles, ?int $interval = null): Contract\IStyleCollection
    {
        $f = new self($interval);
        foreach ($styles as $element) {
            if ($element instanceof IStyle) {
                $f->add($element);
                continue;
            }
            $f->add(Style::create($element));
        }
        return $f;
    }

    public function add(IStyle $style): void
    {
        $this->count++;
        $this->styles[] = $style;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->styles);
    }

    public function toArray(): array
    {
        return $this->styles;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
