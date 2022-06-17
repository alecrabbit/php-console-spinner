<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;

abstract class AWiggler implements IWiggler
{
    protected ?IInterval $interval = null;

    protected function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IRotor $rotor,
    ) {
        $this->interval = $this->extractSmallestInterval($this->style, $this->rotor);
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

    public function getInterval(): ?IInterval
    {
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
        return
            new Frame(
                $this->createSequence(),
                $this->rotor->getWidth(),
            );
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return
            $this->style->join(
                chars: $this->rotor->next($interval),
                interval: $interval,
            );
    }
}
