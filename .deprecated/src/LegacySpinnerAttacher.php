<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerAttacher;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use WeakMap;

final class LegacySpinnerAttacher implements ILegacySpinnerAttacher
{
    public function __construct(
        protected ILoop $loop,
        protected WeakMap $timerMap = new WeakMap(),
    ) {
    }

    public function attach(ILegacySpinner $spinner): void
    {
        $this->detachSpinner($spinner);
        $this->timerMap[$spinner] =
            $this->loop->repeat(
                $spinner->getInterval()->toSeconds(),
                static fn() => $spinner->spin()
            );
    }

    protected function detachSpinner(ILegacySpinner $spinner): void
    {
        if ($this->timerMap->offsetExists($spinner)) {
            $this->loop->cancel($this->timerMap[$spinner]);
            $this->timerMap->offsetUnset($spinner);
        }
    }
}
