<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Kernel\Contract\ILoop;

interface ILoopFactory
{
    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop;

    public function supported(): array;
}
