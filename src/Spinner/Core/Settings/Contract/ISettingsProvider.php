<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISettingsProvider
{
    public function getUserSettings(): ISettings;

    public function getDefaultSettings(): ISettings;

    public function getDetectedSettings(): ISettings;
}
