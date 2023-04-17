<?php

declare(strict_types=1);

// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;

interface IStyleFrameRendererFactory
{
    public function create(OptionStyleMode $mode): IStyleFrameRenderer;
}
