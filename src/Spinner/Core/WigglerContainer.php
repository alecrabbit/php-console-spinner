<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWiggler;

final class WigglerContainer implements Contract\IWigglerContainer
{
    public function __construct(IWiggler ...$wigglers)
    {
        foreach ($wigglers as $wiggler) {
            dump($wiggler);
        }
    }
}
