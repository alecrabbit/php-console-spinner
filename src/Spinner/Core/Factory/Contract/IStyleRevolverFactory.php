<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface IStyleRevolverFactory
{
    public function createStyleRevolver(IStyleLegacyPattern $stylePattern): IFrameRevolver;
}
