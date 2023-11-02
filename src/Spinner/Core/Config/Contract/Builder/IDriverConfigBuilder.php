<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IDriverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IDriverConfig;
}
