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
        protected IFrame $frame,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
    }

    protected function next(?float $dt = null): void
    {
        $this->frame->getSequence(); // simulating frame update
        $this->frame->getWidth(); // simulating frame update
    }

    protected function current(): IFrame
    {
        return $this->frame;
    }
}
