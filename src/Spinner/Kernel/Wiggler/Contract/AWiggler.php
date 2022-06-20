<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\CharFrame;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Kernel\Wiggler\Cycle;
use AlecRabbit\Spinner\Kernel\Wiggler\CycleCalculator;

abstract class AWiggler implements IWiggler
{
    protected ICycle $cycle;
    protected ICharFrame $currentFrame;
    protected ?WIInterval $interval = null;

    protected function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IRotor $rotor,
    ) {
        $this->setInterval();
        $this->cycle = new Cycle(1);
    }

    private function setInterval(?WIInterval $preferredInterval = null): void
    {
        $this->interval = $this->extractSmallestInterval($this->style, $this->rotor, $preferredInterval);
    }

    private function extractSmallestInterval(
        IRotor $first,
        IRotor $second,
        ?WIInterval $preferredInterval = null
    ): ?WIInterval {
        dump(__METHOD__, $this );
        $fInterval = $first->getInterval($preferredInterval);
        $sInterval = $second->getInterval($preferredInterval);

        if (null === $fInterval && null === $sInterval) {
            return null;
        }

        $fInterval = $fInterval ?? $sInterval;

        return $fInterval->smallest($sInterval);
    }

    public function getInterval(?WIInterval $preferredInterval = null): ?WIInterval
    {
        if ($preferredInterval instanceof WIInterval) {
            $this->setCycles($preferredInterval);
        }
        return $this->interval;
    }

    private function setCycles(WIInterval $preferredInterval): void
    {
        $this->setInterval($preferredInterval);
        $this->cycle = new Cycle(CycleCalculator::calculate($preferredInterval, $this->interval));
    }

    public static function create(IStyleRotor $style, IRotor $rotor,): IWiggler
    {
        return
            new static($style, $rotor);
    }

    abstract protected static function assertWiggler(IWiggler|string|null $wiggler): void;

    public function render(): ICharFrame
    {
        if ($this->cycle->completed()) {
            return
                $this->currentFrame =
                    new CharFrame(
                        $this->style->join(
                            $this->rotor->next(),
                        ),
                        $this->rotor->getWidth(),
                    );
        }
        return
            $this->currentFrame;
    }
}
