<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

final readonly class SpinnerSettings implements ISpinnerSettings
{
    public function __construct(
        protected ?IWidgetSettings $widgetSettings = null,
        protected bool $autoAttach = true,
    ) {
    }

    public function getWidgetSettings(): ?IWidgetSettings
    {
        return $this->widgetSettings;
    }

    public function isAutoAttach(): bool
    {
        return $this->autoAttach;
    }
}
