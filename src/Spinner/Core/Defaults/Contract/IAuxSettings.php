<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;

interface IAuxSettings
{
    public function getOptionNormalizerMode(): OptionNormalizerMode;

    public function setOptionNormalizerMode(OptionNormalizerMode $normalizerMode): IAuxSettings;
}
