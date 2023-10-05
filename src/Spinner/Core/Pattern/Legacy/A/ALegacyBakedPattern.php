<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ILegacyBakedPattern;

abstract readonly class ALegacyBakedPattern implements ILegacyBakedPattern
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
