<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use IteratorAggregate;

interface IFrameCollection extends IteratorAggregate
{
    public static function create(iterable|string $frames, ?int $elementWidth = null, ?int $interval = null): self;

    public function add(IFrame $frame): void;

    public function getInterval(): IInterval;

    public function toArray(): array;
}
