<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface IFrameRevolverFactory
{
    public function create(IPalette $palette): IFrameRevolver;
}
