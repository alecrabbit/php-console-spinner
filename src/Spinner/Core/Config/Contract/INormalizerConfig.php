<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;

interface INormalizerConfig extends IConfigElement
{
    public function getNormalizerMode(): NormalizerMode;
}
