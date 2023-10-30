<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IDriverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IDriverConfig;

    public function withLinkerMode(LinkerMode $linkerMode): IDriverConfigBuilder;
}
