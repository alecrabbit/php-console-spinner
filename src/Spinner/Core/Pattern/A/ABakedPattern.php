<?php

declare(strict_types=1);
// 19.04.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;

abstract readonly class ABakedPattern implements IBakedPattern
{
    public function __construct(
        protected IFrameCollection $frames,
        protected IInterval $interval,
    ) {
    }

    public function getFrameCollection(): IFrameCollection
    {
        return $this->frames;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

}
