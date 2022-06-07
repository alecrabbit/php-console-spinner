<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use ArrayIterator;
use Traversable;
use WeakMap;

final class WigglerContainer implements Contract\IWigglerContainer
{
    /**
     * @var IWiggler[]
     */
    private array $wigglers;
    /**
     * @var int[]
     */
    private iterable $wigglersIndexes;
    private int $currentIndex;

    public function __construct(
        IWiggler ...$wigglers,
    ) {
        $this->wigglers = [];
        $this->wigglersIndexes = new WeakMap();
        $this->currentIndex = 0;
        foreach ($wigglers as $wiggler) {
            $this->addWiggler($wiggler);
        }
    }

    public function addWiggler(IWiggler $wiggler): void
    {
        $this->wigglers[$this->currentIndex] = $wiggler;
        $this->wigglersIndexes[$wiggler] = $this->currentIndex;
        $this->currentIndex++;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->wigglers);
    }

    public function getWigglerIndex(string|IWiggler $class): int
    {
        if($class instanceof IWiggler) {
            return $this->wigglersIndexes[$class];
        }
        /** @var IWiggler $wiggler */
        foreach ($this->wigglers as $wiggler) {
            if (is_a($wiggler, $class)) {
                return $this->wigglersIndexes[$wiggler];
            }
        }
        throw new RuntimeException('Wiggler not found');
    }

    public function updateWiggler(int $wigglerIndex, IMessageWiggler|string|null $message): void
    {
        $wiggler = $this->wigglers[$wigglerIndex];
        $updatedWiggler = $wiggler->update($message);
        $this->wigglers[$wigglerIndex] = $updatedWiggler;
        $this->wigglersIndexes[$updatedWiggler] = $wigglerIndex;
        unset($this->wigglersIndexes[$wiggler]);
        dump($updatedWiggler);
    }
}
