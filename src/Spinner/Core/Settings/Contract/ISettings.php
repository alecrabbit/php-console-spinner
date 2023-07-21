<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Core\Settings\Settings;

interface ISettings
{

    public function getAuxSettings(): IAuxSettings;

    public function getWidgetSettings(): IWidgetSettings;

    public function getRootWidgetSettings(): IWidgetSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getLoopSettings(): ILoopSettings;

    public function getOutputSettings(): IOutputSettings;
}
