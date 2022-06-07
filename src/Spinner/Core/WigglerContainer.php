<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use Traversable;
use WeakMap;

final class WigglerContainer implements Contract\IWigglerContainer
{
    /**
     * @var IWiggler[]
     */
    private iterable $wigglers;

    public function __construct(
        private readonly IFrame $leadingFrame,
        private readonly IFrame $trailingFrame,
        IWiggler ...$wigglers,
    ) {
        $this->wigglers = new WeakMap();
        foreach ($wigglers as $wiggler) {
            $this->addWiggler($wiggler);
        }
    }

    public function addWiggler(IWiggler $wiggler): void
    {
        $this->wigglers[$wiggler] = $wiggler;
    }

    /**
     * @return IWiggler[]
     */
    public function getWigglers(): iterable
    {
        return $this->wigglers;
    }

    public function getIterator(): Traversable
    {
        return $this->wigglers->getIterator();
    }

    public function getTrailingFrame(): IFrame
    {
        return $this->trailingFrame;
    }

    public function getLeadingFrame(): IFrame
    {
        return $this->leadingFrame;
    }
}
