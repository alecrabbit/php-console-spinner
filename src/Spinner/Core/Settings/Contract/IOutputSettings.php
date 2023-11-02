<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface IOutputSettings extends ISettingsElement
{
    public function getCursorVisibilityOption(): CursorVisibilityOption;

    public function getStylingMethodOption(): StylingMethodOption;

    public function getInitializationOption(): InitializationOption;

    public function getStream(): mixed;
}
