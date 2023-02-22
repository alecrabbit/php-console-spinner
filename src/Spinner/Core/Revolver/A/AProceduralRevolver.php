<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

abstract class AProceduralRevolver extends ARevolver
{
    protected IFrame $currentFrame;

    public function __construct(
        protected IProcedure $procedure,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    protected function next(float $dt = null): void
    {
        $this->currentFrame = $this->procedure->update($dt);
    }

    protected function current(): IFrame
    {
        return $this->currentFrame;
    }
}
