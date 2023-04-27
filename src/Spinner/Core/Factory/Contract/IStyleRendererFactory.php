<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;

interface IStyleRendererFactory
{
    public function create(OptionStyleMode $styleMode): IStyleRenderer;
}
