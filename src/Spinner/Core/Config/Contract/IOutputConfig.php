<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;

interface IOutputConfig extends IConfigElement
{
    public function getCursorVisibilityMode(): CursorVisibilityMode;

    public function getStylingMode(): StylingMode;

    public function getInitializationMode(): InitializationMode;

    public function getStream(): mixed;
}
