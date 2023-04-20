<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface IStyleRevolverFactory
{
    public function createStyleRevolver(IStylePattern $stylePattern): IFrameRevolver;
}
