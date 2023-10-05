<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;

interface IDetectedSettingsFactory
{
    public function create(): ISettings;
}
