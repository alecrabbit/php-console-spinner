<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface IOutputSettings
{
    public function getCursorVisibilityOption(): CursorVisibilityOption;

    public function setStylingMethodOption(StylingMethodOption $stylingMethodOption): void;

    public function setCursorVisibilityOption(CursorVisibilityOption $cursorVisibilityOption): void;

    public function getStylingMethodOption(): StylingMethodOption;
}
