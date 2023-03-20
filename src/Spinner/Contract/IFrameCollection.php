<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\DomainException;
use ArrayAccess;
use Countable;

/**
 * @template T of IFrame
 * @extends ArrayAccess<int,T>
 */
interface IFrameCollection extends Countable, ArrayAccess
{
    public function get(int $index): IFrame;

    /**
     * @throws DomainException
     */
    public function lastIndex(): int;
}