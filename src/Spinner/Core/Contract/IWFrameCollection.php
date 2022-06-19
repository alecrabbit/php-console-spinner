<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use IteratorAggregate;

interface IWFrameCollection extends IteratorAggregate,
                                    HasInterval
{
    public static function create(iterable|string $frames, ?int $elementWidth = null, ?int $interval = null): self;

    public function add(IFrame $frame): void;

    public function toArray(): array;
}
