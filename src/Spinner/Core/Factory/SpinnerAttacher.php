<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use WeakMap;

final class SpinnerAttacher implements ISpinnerAttacher
{
    public function __construct(
        protected ILoop $loop,
        protected WeakMap $timerMap = new WeakMap(),
    ) {
    }

    public function attach(ISpinner $spinner): void
    {
        $this->detachSpinner($spinner);
        $this->timerMap[$spinner] =
            $this->loop->repeat(
                $spinner->getInterval()->toSeconds(),
                static fn() => $spinner->spin()
            );
    }

    protected function detachSpinner(ISpinner $spinner): void
    {
        if ($this->timerMap->offsetExists($spinner)) {
            $this->loop->cancel($this->timerMap[$spinner]);
            $this->timerMap->offsetUnset($spinner);
        }
    }
}
