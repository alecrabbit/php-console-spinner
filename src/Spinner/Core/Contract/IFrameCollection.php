<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use ArrayAccess;
use Countable;

interface IFrameCollection extends Countable
{
    public function get(int $index): IFrame;

    /**
     * @deprecated
     */
    public function lastIndex(): int;

    public function next(): void;

    public function current(): IFrame;
}
