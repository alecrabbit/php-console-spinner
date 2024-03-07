<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IGeneralConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IGeneralConfig;

    public function withExecutionMode(ExecutionMode $executionMode): IGeneralConfigBuilder;
}
