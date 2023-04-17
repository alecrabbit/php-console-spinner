<?php

declare(strict_types=1);

// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface IStyleRevolverFactory
{
    public function createStyleRevolver(IPattern $stylePattern): IFrameRevolver;
}
