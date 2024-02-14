<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver\Override;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;

final class ARevolverOverride extends ARevolver
{
    public function __construct(
        private IFrame $frame,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    private function next(?float $dt = null): void
    {

    }

    private function current(): IFrame
    {
        return $this->frame;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        {
            // simulating frame update
            $this->frame->getSequence();
            $this->frame->getWidth();
        }
        return $this->current();
    }
}
