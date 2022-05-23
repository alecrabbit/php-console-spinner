<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWiggler;

final class WigglerContainer implements Contract\IWigglerContainer
{
    /**
     * @var IWiggler[]
     */
    private iterable $wigglers;

    public function __construct(IWiggler ...$wigglers
    ) {
        $this->wigglers = $wigglers;
    }

    /**
     * @return IWiggler[]
     */
    public function getWigglers(): iterable
    {
        return $this->wigglers;
    }
}
