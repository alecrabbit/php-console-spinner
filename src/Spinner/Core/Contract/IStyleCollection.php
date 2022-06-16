<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use IteratorAggregate;
use Countable;

interface IStyleCollection extends IteratorAggregate, Countable
{
    public static function create(array $styles, ?int $interval = null): self;

    public function add(IStyle $style): void;

    public function getInterval(): IInterval;

    public function toArray(): array;
}
