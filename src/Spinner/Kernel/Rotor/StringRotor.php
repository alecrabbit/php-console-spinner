<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\AStringRotor;

final class StringRotor extends AStringRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], WidthDefiner::define($string), C::SPACE_CHAR);
    }
}
