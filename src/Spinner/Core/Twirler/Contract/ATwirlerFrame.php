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
        protected readonly ICharFrame $leadingSpacer,
        protected readonly ICharFrame $trailingSpacer,
    ) {
    }

    public function getLeadingSpacer(): ICharFrame
    {
        return $this->leadingSpacer;
    }

    public function getTrailingSpacer(): ICharFrame
    {
        return $this->trailingSpacer;
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
