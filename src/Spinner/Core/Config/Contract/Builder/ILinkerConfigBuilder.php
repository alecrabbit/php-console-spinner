<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface ILinkerConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ILinkerConfig;

    public function withLinkerMode(LinkerMode $linkerMode): ILinkerConfigBuilder;
}
