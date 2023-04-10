<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface ILegacySpinnerSettingsBuilder
{

    public function build(): ISpinnerSettings;
}
