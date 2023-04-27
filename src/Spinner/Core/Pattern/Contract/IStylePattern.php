<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;

interface IStylePattern extends IPattern
{
    public function getStyleMode(): OptionStyleMode;
}
