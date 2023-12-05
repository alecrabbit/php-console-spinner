<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use ArrayAccess;
use Countable;

/**
 * @template T of IFrame
 *
 * @extends ArrayAccess<int,T>
 */
interface IFrameCollection extends Countable, ArrayAccess
{
    /**
     * @psalm-return T
     */
    public function get(int $index): IFrame;

    /**
     * @deprecated
     */
    public function lastIndex(): int;

    public function next(): void;

    public function current(): IFrame;
}
