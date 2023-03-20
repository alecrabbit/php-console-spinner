<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Contract;

use ArrayAccess;
use Countable;

interface IFrameCollection extends Countable, ArrayAccess
{
    public function get(int $index): IFrame;

    public function lastIndex(): ?int;
}