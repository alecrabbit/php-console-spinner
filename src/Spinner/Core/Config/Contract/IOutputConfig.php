<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;

interface IOutputConfig extends IConfigElement
{
    public function getCursorVisibilityMode(): CursorVisibilityMode;

    public function getStylingMethodMode(): StylingMethodMode;
}
