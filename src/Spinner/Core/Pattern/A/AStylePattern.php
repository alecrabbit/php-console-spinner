<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\Contract\ICharPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use Traversable;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    public function getStyleMode(): OptionStyleMode
    {
        // TODO: Implement getStyleMode() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function getEntries(OptionStyleMode $styleMode = OptionStyleMode::ANSI8): Traversable
    {
        // TODO: Implement getEntries() method.
        throw new \RuntimeException('Not implemented.');
    }


}
