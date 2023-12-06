<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Exception\LogicException;
use ArrayAccess;
use Countable;

interface IFrameCollection extends Countable
{
    public function next(): void;

    public function current(): IFrame;
}
