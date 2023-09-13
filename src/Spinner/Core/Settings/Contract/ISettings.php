<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISettings
{
    /** @deprecated */
    public function getAuxSettings(): IAuxSettings;

    /** @deprecated */
    public function getWidgetSettings(): IWidgetSettings;

    /** @deprecated */
    public function getRootWidgetSettings(): IWidgetSettings;

    /** @deprecated */
    public function getDriverSettings(): IDriverSettings;

    /** @deprecated */
    public function getLoopSettings(): ILoopSettings;

    /** @deprecated */
    public function getOutputSettings(): IOutputSettings;
}
