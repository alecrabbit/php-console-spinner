<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\DomainException;

interface ILoopFactory
{
    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop;

    public function supported(): array;
}
