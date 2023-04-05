<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetSettingsBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetSettings;
}
