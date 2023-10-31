<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use Traversable;

interface ISignalHandlerSettings extends ISettingsElement
{
    public function getCreators(): Traversable;
}
