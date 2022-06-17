<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Wiggler\Cycle;
use AlecRabbit\Spinner\Core\Wiggler\CycleCalculator;

abstract class AWiggler implements IWiggler
{
    protected ICycle $cycle;
    protected IFrame $currentFrame;
    protected ?IInterval $interval = null;

    protected function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IRotor $rotor,
    ) {
        $this->interval = $this->extractSmallestInterval($this->style, $this->rotor);
        $this->cycle = new Cycle(1);
    }

    private function extractSmallestInterval(IRotor $first, IRotor $second): ?IInterval
    {
        $fInterval = $first->getInterval();
        $sInterval = $second->getInterval();

        if (null === $fInterval && null === $sInterval) {
            return null;
        }

        $fInterval = $fInterval ?? $sInterval;

        return $fInterval->smallest($sInterval);
    }

    public function getInterval(?IInterval $preferredInterval = null): ?IInterval
    {
        if($preferredInterval instanceof IInterval) {
            $this->setCycles($preferredInterval);
        }
        return $this->interval;
    }

    public static function create(IStyleRotor $style, IRotor $rotor,): IWiggler
    {
        return
            new static($style, $rotor);
    }

    abstract protected static function assertWiggler(IWiggler|string|null $wiggler): void;

    public function render(): IFrame
    {
        if ($this->cycle->completed()) {
            return
                $this->currentFrame =
                    new Frame(
                        $this->style->join(
                            $this->rotor->next(),
                        ),
                        $this->rotor->getWidth(),
                    );
        }
        return
            $this->currentFrame;
    }

    private function setCycles(IInterval $preferredInterval): void
    {
        $this->cycle = new Cycle(CycleCalculator::calculate($preferredInterval, $this->interval));
    }
}
