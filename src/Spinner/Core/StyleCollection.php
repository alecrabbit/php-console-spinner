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
    private IInterval $interval;

    protected function __construct(?int $interval = null)
    {
        $seconds = ($interval ?? Defaults::MILLISECONDS_INTERVAL) / 1000;
        $this->interval = new Interval($seconds);
    }

    public static function create(iterable $styles, ?int $interval = null): Contract\IStyleCollection
    {
        $f = new self($interval);
        foreach ($styles as $level => $element) {
            $f->add($level, $element);
        }
        return $f;
    }

    public function add(int $level, iterable $element): void
    {
        $this->styles[$level] = $element['sequence'];
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->styles);
    }

    /**
     * @return array<int, IStyle>
     */
    public function toArray(int $colorSupportLevel): array
    {
        return $this->styles[$colorSupportLevel];
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
