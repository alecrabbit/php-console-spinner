<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\A;

use AlecRabbit\Spinner\Core\Config\Contract\Solver\ISolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

abstract class ASolver implements ISolver
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
    ) {
    }

    abstract public function solve(): mixed;

    /**
     * @param ISettings $settings
     * @param class-string<ISettingsElement> $id
     * @return ISettingsElement|null
     */
    protected function extractElement(ISettings $settings, string $id): ?ISettingsElement
    {
        return $settings->get($id);
    }
}
