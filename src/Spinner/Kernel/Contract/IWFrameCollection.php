<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use IteratorAggregate;

interface IWFrameCollection extends IteratorAggregate,
                                    HasInterval
{
    public static function create(iterable|string $frames, ?int $elementWidth = null, ?int $interval = null): self;

    public function add(ICharFrame $frame): void;

    public function toArray(): array;
}
