<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use ArrayIterator;
use Traversable;
use WeakMap;

final class WigglerContainer implements Contract\IWigglerContainer
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

    public function __construct(
        private readonly IInterval $interval,
        IWiggler ...$wigglers,
    ) {
        $this->indexes = new WeakMap();
        foreach ($wigglers as $wiggler) {
            $this->addWiggler($wiggler);
        }
    }

    public function addWiggler(IWiggler $wiggler): void
    {
        $this->wigglers[$this->currentIndex] = $wiggler;
        $this->indexes[$wiggler] = $this->currentIndex;
        $this->currentIndex++;
    }

    public function render(): IFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->wigglers as $wiggler) {
            $frame = $wiggler->createFrame($this->interval);
            $sequence .= $frame->sequence;
            $width += $frame->sequenceWidth;
        }

        return
            new Frame(
                $sequence,
                $width
            );
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->wigglers);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
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
    public function getIndex(string|IWiggler $objectOrClass): int
    {
        if ($objectOrClass instanceof IWiggler) {
            return $this->indexes[$objectOrClass]; // object
        }
        foreach ($this->wigglers as $wiggler) {
            if (is_a($wiggler, $objectOrClass)) { // class
                return $this->indexes[$wiggler];
            }
        }
        throw new RuntimeException('Wiggler not found');
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
