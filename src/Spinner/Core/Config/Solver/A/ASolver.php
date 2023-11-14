<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\A;

use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

abstract readonly class ASolver implements ISolver
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
    ) {
    }

    /** @inheritDoc */
    abstract public function solve(): mixed;

    /**
     * @psalm-template T of ISettingsElement
     * @psalm-param ISettings $settings
     * @psalm-param class-string<T> $id
     * @psalm-return T|null
     */
    protected function extractSettingsElement(ISettings $settings, string $id): ?ISettingsElement
    {
        return $settings->get($id);
    }
}
