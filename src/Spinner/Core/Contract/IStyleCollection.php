<?php
declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use IteratorAggregate;

interface IStyleCollection extends IteratorAggregate
{
    public static function create(iterable $styles, ?int $interval = null): self;

    public function add(int $level, iterable $element): void;

    public function getInterval(): IInterval;

    public function toArray(int $colorSupportLevel): array;
}
