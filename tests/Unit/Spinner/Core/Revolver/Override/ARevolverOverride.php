<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver\Override;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;

final class ARevolverOverride extends ARevolver
{
    public function __construct(
        protected IFrame $frame,
        IInterval $interval,
        int $deltaTolerance,
    ) {
        parent::__construct($interval, $deltaTolerance);
    }

    protected function next(?float $dt = null): void
    {
        $this->frame->sequence(); // simulating frame update
        $this->frame->width(); // simulating frame update
    }

    protected function current(): IFrame
    {
        return $this->frame;
    }
}
