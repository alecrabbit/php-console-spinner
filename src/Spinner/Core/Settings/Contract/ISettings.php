<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISettings
{
    public function set(ISettingsElement ...$settingsElements): void;

    /**
     * @param class-string<ISettingsElement> $id
     */
    public function get(string $id): ?ISettingsElement;
}
