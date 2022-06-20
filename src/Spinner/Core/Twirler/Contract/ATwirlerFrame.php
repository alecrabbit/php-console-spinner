<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;

abstract class ATwirlerFrame implements ITwirlerFrame
{
    public function __construct(
        protected readonly IStyleFrame $styleFrame,
        protected readonly ICharFrame $charFrame,
    ) {
    }

    public function getStyleFrame(): IStyleFrame
    {
        return $this->styleFrame;
    }

    public function getCharFrame(): ICharFrame
    {
        return $this->charFrame;
    }

}
