<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver\Override;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;

final class ARevolverOverride extends ARevolver
{
    public function __construct(
        private ISequenceFrame $frame,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    public function getFrame(?float $dt = null): ISequenceFrame
    {
        {
            // simulating frame update
            $this->frame->getSequence();
            $this->frame->getWidth();
        }
        return $this->current();
    }

    private function current(): ISequenceFrame
    {
        return $this->frame;
    }

}
