<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Exception\DomainException;

interface ILoopFactory
{
    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop;

    public function supported(): array;
}
