<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\TwirlerFrame;

abstract class ATwirler implements ITwirler
{
    protected ITwirlerFrame $currentFrame;

    public function __construct(
        protected readonly IStyleRevolver $styleRevolver,
        protected readonly ICharRevolver $charRevolver,
    ) {
    }

    public function render(): ITwirlerFrame
    {
        return new TwirlerFrame(
            $this->styleRevolver->next(),
            $this->charRevolver->next(),
        );
    }
}
