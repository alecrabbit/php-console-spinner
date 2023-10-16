<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

interface IAuxConfig extends IConfigElement
{
    public function getRunMethodMode(): RunMethodMode;

    public function getNormalizerMode(): NormalizerMode;
}
