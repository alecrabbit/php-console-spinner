<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISpinnerSettings
{

    public function getWidgetSettings(): IWidgetSettings;

    public function isAutoAttach(): bool;
}
