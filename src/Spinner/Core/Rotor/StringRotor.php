<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\AStringRotor;
use AlecRabbit\Spinner\Core\WidthDefiner;

final class StringRotor extends AStringRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], WidthDefiner::define($string), C::SPACE_CHAR);
    }
}
