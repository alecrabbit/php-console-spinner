<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;

interface IStyleFrameRendererFactory
{
    public function create(OptionStyleMode $mode): IStyleFrameRenderer;
}
