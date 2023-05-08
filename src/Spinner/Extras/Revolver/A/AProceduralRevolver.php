<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

abstract class AProceduralRevolver extends ARevolver implements IFrameRevolver
{
    protected IFrame $currentFrame;

    public function __construct(
        protected IProcedure $procedure,
        IInterval $interval,
    ) {
        parent::__construct($interval);
        $this->currentFrame = CharFrame::createEmpty();
    }

    protected function next(?float $dt = null): void
    {
        $this->currentFrame = $this->procedure->getFrame($dt);
    }

    protected function current(): IFrame
    {
        return $this->currentFrame;
    }
}
