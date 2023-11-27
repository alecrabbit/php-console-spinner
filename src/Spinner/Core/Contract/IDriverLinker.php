<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface IDriverLinker extends IObserver
{
    /**
     * @throws LogicException
     * @throws InvalidArgument
     */
    public function link(IDriver $driver): void;
}
