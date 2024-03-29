<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Exception\LogicException;

interface IDriverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IDriverConfig;

    public function withDriverMessages(IDriverMessages $driverMessages): IDriverConfigBuilder;

    public function withDriverMode(DriverMode $driverMode): IDriverConfigBuilder;
}
