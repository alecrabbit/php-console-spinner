<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Builder;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Exception\LogicException;

interface ISettingsProviderBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ISettingsProvider;
}
