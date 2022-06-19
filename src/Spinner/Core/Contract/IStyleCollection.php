<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use Countable;
use IteratorAggregate;

interface IStyleCollection extends Countable,
                                   HasInterval,
                                   IteratorAggregate
{
    public static function create(array $styles, ?int $interval = null): self;

    public function add(IStyle $style): void;

    public function toArray(): array;
}
