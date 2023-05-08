<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

interface IStylePattern extends IPattern
{
    public function getStyleMode(): OptionStyleMode;

    public function getEntries(OptionStyleMode $styleMode = OptionStyleMode::ANSI8): Traversable;
}
