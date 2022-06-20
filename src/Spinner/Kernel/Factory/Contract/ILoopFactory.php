<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Kernel\Contract\ILoop;
use AlecRabbit\Spinner\Kernel\Exception\DomainException;

interface ILoopFactory
{
    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop;

    public function supported(): array;
}
