<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDriverSettingsBuilder
{
    public function build(): IDriverSettings;
}
