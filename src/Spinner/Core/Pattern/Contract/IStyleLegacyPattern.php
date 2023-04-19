<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;

interface IStyleLegacyPattern extends ILegacyPattern
{
    public function getStyleMode(): OptionStyleMode;
}
