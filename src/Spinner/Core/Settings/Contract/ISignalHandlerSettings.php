<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISignalHandlerSettings extends ISettingsElement
{

    public function getCreators(): \Traversable;
}
