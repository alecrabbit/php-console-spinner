<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Contract;

use Traversable;

interface IPattern
{
    public function getPattern(): Traversable;

    public function getInterval(): IInterval;
}
