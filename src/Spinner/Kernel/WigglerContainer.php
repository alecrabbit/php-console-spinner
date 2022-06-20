<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Exception\RuntimeException;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Kernel\Rotor\Interval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;
use ArrayIterator;
use Traversable;
use WeakMap;

final class WigglerContainer implements IWigglerContainer
{
    /**
     * @var IWiggler[]
     */
    private array $wigglers = [];
    /**
     * @var int[]
     */
    private iterable $indexes;
    private int $currentIndex = 0;
    private ?IInterval $calculatedInterval = null;
    private ?IInterval $preferredInterval;

    public function __construct(
        ?IInterval $preferredInterval = null,
    ) {
        $this->preferredInterval = $preferredInterval;
        $this->indexes = new WeakMap();
    }

    public function addWiggler(IWiggler $wiggler): IWigglerContainer
    {
        // TODO (2022-06-15 19:06) [Alec Rabbit]: if wiggler interval is smaller than current interval,
        //  then change current interval to wiggler interval.

        $this->wigglers[$this->currentIndex] = $wiggler;
        $this->indexes[$wiggler] = $this->currentIndex;
        $this->currentIndex++;
        $this->updateInterval($wiggler->getInterval());
        return $this;
    }

    private function updateInterval(?IInterval $interval): void
    {
        $this->calculatedInterval =
            $this->calculatedInterval instanceof IInterval
                ? $this->calculatedInterval->smallest($interval)
                : $interval;
    }

    public function getInterval(): IInterval
    {
        $this->calculatedInterval = $this->calculateInterval($this->preferredInterval);

        return
            $this->preferredInterval ?? $this->calculatedInterval;
    }

    private function calculateInterval(?IInterval $preferredInterval): IInterval
    {
        $preferredInterval = $preferredInterval ?? new Interval(1000);
//        foreach ($this->wigglers as $wiggler) {
//            $wiggler->
//        }

        return $this->calculatedInterval;
    }

    public function render(): ICharFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->wigglers as $wiggler) {
            $frame = $wiggler->render();
            $sequence .= $frame->char;
            $width += $frame->sequenceWidth;
        }

        return
            new CharFrame(
                $sequence,
                $width
            );
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->wigglers);
    }

    public function spinner(string|IRevolveWiggler|null $wiggler): void
    {
        $this->updateWiggler(
            $this->getIndex(IRevolveWiggler::class),
            $wiggler
        );
    }

    public function updateWiggler(int $wigglerIndex, IWiggler|string|null $wiggler): void
    {
        $currentWiggler = $this->wigglers[$wigglerIndex];
        $updatedWiggler = $currentWiggler->update($wiggler);
        $this->wigglers[$wigglerIndex] = $updatedWiggler;
        $this->indexes[$updatedWiggler] = $wigglerIndex;
        unset($this->indexes[$currentWiggler]);
    }

    /**
     * @throws RuntimeException
     */
    protected function getIndex(string|IWiggler $objectOrClass): int
    {
        if ($objectOrClass instanceof IWiggler) {
            return $this->indexes[$objectOrClass]; // object
        }
        foreach ($this->wigglers as $wiggler) {
            if (is_a($wiggler, $objectOrClass)) { // class
                return $this->indexes[$wiggler];
            }
        }
        throw new RuntimeException('Wiggler not found.');
    }

    public function progress(float|string|IProgressWiggler|null $wiggler): void
    {
        if (is_float($wiggler)) {
            $wiggler = sprintf('%s%%', (int)($wiggler * 100)); // convert to string
        }

        $this->updateWiggler(
            $this->getIndex(IProgressWiggler::class),
            $wiggler
        );
    }

    public function message(string|IMessageWiggler|null $wiggler): void
    {
        $this->updateWiggler(
            $this->getIndex(IMessageWiggler::class),
            $wiggler
        );
    }
}
