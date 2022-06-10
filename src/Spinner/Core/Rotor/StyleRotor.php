<?php
declare(strict_types=1);
// 10.06.22
namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\IStyleCollection;
use AlecRabbit\Spinner\Core\Rotor\Contract\AStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class StyleRotor extends AStyleRotor
{
    public function __construct(
        IStyleCollection $styles,
    ) {
        parent::__construct($styles->toArray());
    }

    public function join(string $chars, ?IInterval $interval = null): string
    {
        // TODO: Implement join() method.
    }
}
