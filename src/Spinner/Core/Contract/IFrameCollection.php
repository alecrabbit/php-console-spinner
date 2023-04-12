<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayAccess;
use Countable;

/**
 * @template T of IFrame
 * @extends ArrayAccess<int,T>
 */
interface IFrameCollection extends Countable, ArrayAccess
{
    /**
     * @return T
     */
    public function get(int $index): IFrame;

    public function lastIndex(): int;
}
