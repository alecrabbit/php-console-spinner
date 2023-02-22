<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IConfigBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig;
}
