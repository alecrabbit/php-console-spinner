<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISettingsElement
{
    /**
     * @return class-string<ISettingsElement>
     */
    public function getIdentifier(): string;
}
