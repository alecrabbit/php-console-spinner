<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use Countable;

interface IFrameCollection extends Countable
{
    public function next(): void;

    public function current(): IFrame;
}
