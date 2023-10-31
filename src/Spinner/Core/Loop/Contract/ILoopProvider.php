<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Exception\DomainException;

interface ILoopProvider
{
    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop;

    public function hasLoop(): bool;
}
