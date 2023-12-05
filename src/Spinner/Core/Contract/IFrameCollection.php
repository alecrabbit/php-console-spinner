<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use ArrayAccess;
use Countable;

interface IFrameCollection extends Countable
{
    /**
     * @deprecated Use combination of next() and current() instead
     */
    public function get(int $index): IFrame;

    /**
     * @deprecated
     */
    public function lastIndex(): int;

    public function next(): void;

    public function current(): IFrame;
}
