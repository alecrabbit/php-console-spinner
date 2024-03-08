<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingOption;

interface IOutputSettings extends ISettingsElement
{
    public function getCursorOption(): CursorOption;

    public function getStylingOption(): StylingOption;

    public function getInitializationOption(): InitializationOption;

    public function getStream(): mixed;
}
