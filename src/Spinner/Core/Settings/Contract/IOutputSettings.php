<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingOption;

interface IOutputSettings extends ISettingsElement
{
    public function getCursorVisibilityOption(): CursorVisibilityOption;

    public function getStylingOption(): StylingOption;

    public function getInitializationOption(): InitializationOption;

    public function getStream(): mixed;
}
